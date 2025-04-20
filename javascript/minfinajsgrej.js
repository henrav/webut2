// ska bara användas för edit grejer och så på "profil" sidan


window.getDelete = function(id) {

    const idd = id;
    const hiddenDiv = document.getElementById('gömdaDiven');
    hiddenDiv.innerHTML += `
    <div class="screen-overlay">
      <div class="screen-dialog">
        <h2>Vill du radera inlägg ${id}?</h2>
        <div class="screen-buttons">
          <button onclick="removePost('${id}')">
            Ja, radera
          </button>
          <button onclick="removeOverlay()">
            Nej, avbryt
          </button>
        </div>
      </div>
    </div>
  `;
};


window.removeOverlay = function() {
    const hiddenDiv = document.getElementById('gömdaDiven');
    if (hiddenDiv) {
        hiddenDiv.innerHTML = '';
    }
}

window.removePost = async function (id) {
    console.log('removing');
    try {
        const reponse = await fetch(`../dbGrejer/apiGrejsenFragetecken.php?id=${id}&delete=true`, {
            method: 'GET',
        });
        if (!reponse.ok) {
            throw new Error('Network response was not ok');
        } else {
            console.log('Post removed successfully');
        }
        removeOverlay();
        window.location.reload();
    }catch(err){
            console.error('Error removing post:', err);
        }
        removeOverlay();
}

window.getEditProfile = async function(id){
    const hiddenDiv = document.getElementById('gömdaDiven');
    const data = await getUserInfo(id);
    hiddenDiv.innerHTML += `
    <div class="screen-overlay" id="post-${id}">
      <div class="screen-dialog big">
        <div class="screen-dialog-flex">
            <div class="screen-dialog-header">Redigera din profil</div>
            <div class="input-container" style="margin-top: 20px">
                  <div class="input-description">Byt namn: </div>
                  <textarea id="username" class="screen-dialog-edit-profile-input">${data['username']}</textarea>
            </div>
            <div class="input-container">
                  <div class="input-description">Byt titel: </div>
                  <textarea id="title" class="screen-dialog-edit-profile-input">${data['title']}</textarea>
            </div>
            <div class="input-container" style="margin-bottom: 20px">
                  <div class="input-description">Byt "Om mig": </div>
                  <textarea id="presentation" class="screen-dialog-edit-profile-input largetext">${data['presentation']}</textarea>
            </div>
            <div class="screen-dialog-footer">
                <button id="spara" class="edit-button spara">Spara</button>
                <button class="edit-button avbryt" onclick="removeOverlay()">Avbryt</button>
            </div>
        </div>  
      </div>
    </div>
  `;
    document
        .getElementById(`spara`)
        .addEventListener('click', function() {
            const username = document.getElementById('username').value;
            const titel = document.getElementById('title').value;
            const presentation = document.getElementById('presentation').value;

            saveProfileEdit(id, titel, presentation, username);
            removeOverlay();
        });

}

window.saveProfileEdit = async function (id, title, presentation, username){
    const data = {id, title, presentation, username};
    console.log(data);
    try{
        const response = await fetch(`../dbGrejer/apiGrejsenFragetecken.php?updateUser=true`, {
            method: 'POST',
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(data)
        })
        if (!response.ok) {
            throw new Error('Network response was not ok');
        } else {
            console.log('sparade typ normalt eller något');
        }
        return await response.json().then(() =>{
            window.location.reload();
        });

    }catch (e){
        console.log('error när vi eller du skulle spara ändringar typ')
    }
}

window.getUserInfo = async function (id){
    try{
        const response = await fetch(`../dbGrejer/apiGrejsenFragetecken.php?id=${id}&userInfo=true`, {
            method: 'GET',
        });
        if (!response.ok) {
            throw new Error('Network response was not ok');
        } else {
            console.log('hämtade  infon korrekt');
        }
        return await response.json();

    }catch (e){
        console.log('error hämta info', e);
    }
}


window.getEditPost = async function (id) {
    const hiddenDiv = document.getElementById('gömdaDiven');
    const text = await getPostText(id);
    hiddenDiv.innerHTML += `
    <div class="screen-overlay" id="post-${id}">
      <div class="screen-dialog big">
        <div class="screen-dialog-flex">
            <div class="screen-dialog-header">Redigera din post</div>
            <div class="kommer-inte-på-namn">
            Ändra titel
            <textarea id="title-content" class="screen-dialog-change-title" maxlength="50">${text['title']}</textarea>
            </div>
            <textarea id="text-content" class="screen-dialog-text-content">${text['content']}</textarea>
            <div class="screen-dialog-footer">
                <button id="spara" class="edit-button spara">Spara</button>
                <button class="edit-button avbryt" onclick="removeOverlay()">Avbryt</button>
            </div>
        </div>  
      </div>
    </div>
  `;
    document
        .getElementById(`spara`)
        .addEventListener('click', function() {
            const newTitle   = document.getElementById(`title-content`).value;
            const newContent = document.getElementById(`text-content`).value;

            savePostEdit(id, newContent, newTitle);
            removeOverlay();
            window.location.reload();
        });
}


window.addPost = function (userID){
    const hiddenDiv = document.getElementById('gömdaDiven');
    hiddenDiv.innerHTML += `
    <div class="screen-overlay" id="post-${userID}">
      <div class="screen-dialog big">
        <div class="screen-dialog-flex">
            <div class="screen-dialog-header">Ny blogginlägg</div>
            <div class="kommer-inte-på-namn">
             titel
            <textarea id="title-content" class="screen-dialog-change-title" maxlength="50"></textarea>
            </div>
            <textarea id="text-content" class="screen-dialog-text-content"></textarea>
            <div class="screen-dialog-footer">
                <button id="spara" class="edit-button spara">Spara</button>
                <button class="edit-button avbryt" onclick="removeOverlay()">Avbryt</button>
            </div>
        </div>  
      </div>
    </div>
  `;
    document
        .getElementById(`spara`)
        .addEventListener('click', function() {
            const newTitle   = document.getElementById(`title-content`).value;
            const newContent = document.getElementById(`text-content`).value;
            const RandomIDFörJagGlömdeHurDatabaseFungerarFörPostenHarIngenIDFörDenHarSkapatsIDatabase = Math.floor(Math.random() * 100);
            savePostEdit(RandomIDFörJagGlömdeHurDatabaseFungerarFörPostenHarIngenIDFörDenHarSkapatsIDatabase, newContent, newTitle, userID);
            removeOverlay();



        });
}



window.getPostText = async function(id){
    try{
        const response = await fetch(`../dbGrejer/apiGrejsenFragetecken.php?id=${id}&text=true`,{
            method: 'GET',
        })
        if (!response.ok) {
            throw new Error('Network response was not ok');
        } else {
            console.log('hämtade texten normalt typ');
        }
        return await response.json();

    }catch (e){
        console.log('error hämta text', e);
    }
}

window.savePostEdit = async function(id, text, title, userid=null){
        let edit = true;
        if (userid !== null){
            edit =false;
        }

    try {
        const data = { id, text, title, userid };
        console.log(data)
        const response = await fetch(`../dbGrejer/apiGrejsenFragetecken.php?savepost=true&edit=${edit}`,{
            method:'POST',
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(data)
        });
        if (!response.ok) {
            throw new Error('Network response was not ok');
        } else {
            console.log('sparade typ normalt eller något');
        }
        return await response.json().then(() =>{
            window.location.reload();
        });
    }catch (e){
        console.log('nånting error spara postedit')
    }
}