// ska bara användas för edit grejer och så på "profil" sidan
const API_BASE = 'dbGrejer/apiGrejsenFragetecken.php';


window.getDelete = function(id) {
    // hämtar delete lådan
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
    // tar bort overlayen
    const hiddenDiv = document.getElementById('gömdaDiven');
    if (hiddenDiv) {
        hiddenDiv.innerHTML = '';
    }
}

// tar emot id och deletar de i db
// finns i dbGrejer/apoGrejsenFragetecken.php på rad 15
// finns i dbGrejer/apoGrejsenFragetecken.php på rad 15
window.removePost = async function (id) {
    console.log('removing');
    try {
        const reponse = await fetch(`${API_BASE}?id=${id}&delete=true`, {
            method: 'GET',
        });
        if (!reponse.ok) {
            throw new Error('nånting gick dåligt');
        } else {
            console.log('deletad');
        }
        removeOverlay();
        window.location.reload();
    }catch(err){
            console.error('error ta bort:', err);
        }
        removeOverlay();
}


// tar emot id(userid) och lägger till html den i den gömda diven
// fför att redigera profilen
window.getEditProfile = async function(id){
    const hiddenDiv = document.getElementById('gömdaDiven');
    const data = await getUserInfo(id); // hämtar datan om profilen från db så man vet vad man ändrar
    hiddenDiv.innerHTML += `
    <div class="screen-overlay" id="post-${id}">
      <div class="screen-dialog big">
        <div class="screen-dialog-flex">
            <div class="screen-dialog-header">Redigera din profil</div>
            <div class="input-container" style="margin-top: 20px">
                  <div class="input-description">Byt namn: </div>
                  <textarea id="username" class="screen-dialog-edit-profile-input" maxlength="30">${data['username']}</textarea>
            </div>
            <div class="input-container">
                  <div class="input-description">Byt titel: </div>
                  <textarea id="title" class="screen-dialog-edit-profile-input" maxlength="50">${data['title']}</textarea>
            </div>
            <div class="input-container" style="margin-bottom: 20px">
                  <div class="input-description">Byt "Om mig": </div>
                  <textarea id="presentation" class="screen-dialog-edit-profile-input largetext" maxlength="300">${data['presentation']}</textarea>
            </div>
            <div class="screen-dialog-footer">
                <button id="spara" class="edit-button spara">Spara</button>
                <button class="edit-button avbryt" onclick="removeOverlay()">Avbryt</button>
            </div>
        </div>  
      </div>
    </div>
  `;

    // lägger till lyssnare på knapparna så hämtar vi datan som användaren hade skrivit in
    document
        .getElementById(`spara`)
        .addEventListener('click', function() {
            const username = document.getElementById('username').value;
            const titel = document.getElementById('title').value;
            const presentation = document.getElementById('presentation').value;

            // när vi får respons, ta bort overlay och uppdatera sidan så man ser sin ändring
            saveProfileEdit(id, titel, presentation, username).then(() => {
                removeOverlay();
                window.location.reload();
            })
        });

}

// spara ändringar på usern
// finns i dbGrejer/apiGrejsenFragetecken.php på rad 181
// finns i dbGrejer/apiGrejsenFragetecken.php på rad 181
window.saveProfileEdit = async function (id, title, presentation, username){
    const data = {id, title, presentation, username};
    console.log(data);
    try{
        const response = await fetch(`${API_BASE}?updateUser=true`, {
            method: 'POST',
            headers: {"Content-Type": "application/json"},
            body: JSON.stringify(data)
        })
        if (!response.ok) {
            throw new Error('nånting gick fel');
        } else {
            console.log('sparade typ normalt eller något');
        }
        return await response.json();

    }catch (e){
        console.log('error när vi eller du skulle spara ändringar typ')
    }
}

//hämtar userinfo från db så vi kan sätta in det i redigeringsfälten åt användaren
// finns i dbGrejer/apiGrejsenFragetecken.php på rad 161
// finns i dbGrejer/apiGrejsenFragetecken.php på rad 161
window.getUserInfo = async function (id){
    try{
        const response = await fetch(`${API_BASE}?id=${id}&userInfo=true`, {
            method: 'GET',
        });
        if (!response.ok) {
            throw new Error('nånting gick fel');
        } else {
            console.log('hämtade  infon korrekt');
        }
        return await response.json();

    }catch (e){
        console.log('error hämta info', e);
    }
}


// lägger till redigerings ruta för post i den gömda diven
window.getEditPost = async function (id) {
    const hiddenDiv = document.getElementById('gömdaDiven');
    const text = await getPostText(id);// här hämtar vi datan som redan finns i db
    hiddenDiv.innerHTML += `
    <div class="screen-overlay" id="post-${id}">
      <div class="screen-dialog big">
        <div class="screen-dialog-flex">
            <div class="screen-dialog-header">Redigera din post</div>
            <div class="kommer-inte-på-namn">
            Ändra titel
            <textarea id="title-content-${id}" class="screen-dialog-change-title" maxlength="50">${text['title']}</textarea>
            </div>
            <textarea id="text-content-${id}" class="screen-dialog-text-content" minlength="">${text['content']}</textarea>
            <div class="upload-container">
                <h3 style="margin-bottom: 0">Byt bild</h3>
                <p class="upload-explain"></p>
                    <input type="file" id="myFile-${id}" name="filename" hidden>
                    <label for="myFile-${id}" class="redigera">Välj fil</label>
                    <span id="file-name-${id}" style="margin-left: 0.5rem; color: #555;">Ingen fil vald</span>
                    <button id="uploadBtn-${id}" type="submit" class="redigera" style="background-color: #006ae0; color: white; display: none" >Ladda upp</button>
                </div>
                <div style="display: flex; flex-direction: row; align-content: center ">
                <p>Bild description: </p>
                    <textarea id="file-description-${id}" class="file-description-textarea">${text['description']}</textarea>
                </div>
                <div class="screen-dialog-footer">
                    <button id="spara" class="edit-button spara">Spara</button>
                    <button class="edit-button avbryt" onclick="removeOverlay()">Avbryt</button>
                </div>
               
            </div>  
          </div>
        </div>
      `;

    // event lyssnare på filgrejen så texxten kommer upp
        const fileInput = document.getElementById('myFile-'+id);
        const fileNameEl = document.getElementById('file-name-'+id);
        fileInput.addEventListener("change", () => {
            if (fileInput.files.length > 0) {
                fileNameEl.textContent = fileInput.files[0].name;
            } else {
                fileNameEl.textContent = 'Ingen fil vald';
            }
        })

    // event lyssnare på "spara" knappen, hämta alla element och deras data. lägg in i form, skicka till "savePostEdit"
    document.getElementById(`spara`).addEventListener('click', function() {
            const newTitle   = document.getElementById(`title-content-${id}`).value;
            const newContent = document.getElementById(`text-content-${id}`).value;
            const fileInput  = document.getElementById(`myFile-${id}`);
            const bildDescription = document.getElementById(`file-description-${id}`) .value;
            const formData   = new FormData();
            formData.append('id', id);
            formData.append('text', newContent);
            formData.append('title', newTitle);
            formData.append('description', bildDescription)
            if (fileInput.files.length > 0) {
                formData.append('filename', fileInput.files[0]);
            }

            console.log(formData);
            savePostEdit(formData, true).then( ()=>{
                removeOverlay();
                window.location.reload();
        })
    });
}


// vi använder den i profile.php för att lägga till lyssnare på "ändra profilbild" knappen
// funkar typ som alla andra lyssnare i denhär filen
window.addListenerUpload = function (){

    const fileInput  = document.getElementById('myFile');
    const fileNameEl = document.getElementById('file-name');
    const submitBtn  = document.getElementById('uploadBtn');

    // vi vill endast visa knappen "spara ändring" om användaren har laddat upp en bild som dem vill ändra till
    fileInput.addEventListener('change', () => {
        // om den har något i sig, visa
        if (fileInput.files.length > 0) {
            fileNameEl.textContent = fileInput.files[0].name;
            submitBtn.style.display = 'block';
        } else { // annars visa inte
            fileNameEl.textContent = 'Ingen fil vald';
            submitBtn.style.display = 'none';
        }
    });
}

// popup för att lägga till en ny post
window.addPost = function (userID){
    const hiddenDiv = document.getElementById('gömdaDiven');
    hiddenDiv.innerHTML += `
    <div class="screen-overlay" id="post-${userID}">
      <div class="screen-dialog big">
        <div class="screen-dialog-flex">
            <div class="screen-dialog-header">Ny post</div>
            <div class="kommer-inte-på-namn">
            Ändra titel
            <textarea id="title-content-${userID}" class="screen-dialog-change-title" maxlength="50"></textarea>
            </div>
            <textarea id="text-content-${userID}" class="screen-dialog-text-content"></textarea>
            <div class="upload-container">
                <h3 style="margin-bottom: 0">Lägg till bild</h3>
                <p class="upload-explain"></p>
                    <input type="file" id="myFile-${userID}" name="filename" hidden>
                    <label for="myFile-${userID}" class="redigera">Välj fil</label>
                    <span id="file-name-${userID}" style="margin-left: 0.5rem; color: #555;">Ingen fil vald</span>
                    <button id="uploadBtn-${userID}" type="submit" class="redigera" style="background-color: #006ae0; color: white; display: none" >Ladda upp</button>
                </div>
                <div style="display: flex; flex-direction: row; align-content: center ">
                <p>Bild description: </p>
                    <textarea id="file-description-${userID}" class="file-description-textarea"></textarea>
                </div>
                <div class="screen-dialog-footer">
                    <button id="spara" class="edit-button spara">Spara</button>
                    <button class="edit-button avbryt" onclick="removeOverlay()">Avbryt</button>
                </div>
               
            </div>  
          </div>
        </div>
      `;

    // samma lyssnare som på alla, inte mycket DRY här men aaah
    const fileInput = document.getElementById('myFile-'+userID);
    const fileNameEl = document.getElementById('file-name-'+userID);
    fileInput.addEventListener("change", () => {
        if (fileInput.files.length > 0) {
            fileNameEl.textContent = fileInput.files[0].name;
        } else {
            fileNameEl.textContent = 'Ingen fil vald';
        }
    })
    document
        .getElementById(`spara`)
        .addEventListener('click', function() {
            const newTitle   = document.getElementById('title-content-'+userID).value;
            const newContent = document.getElementById('text-content-' + userID).value;
            const fileInput  = document.getElementById('myFile-' + userID);
            const description = document.getElementById('file-description-' + userID).value;

            const formData = new FormData();
            formData.append('title', newTitle);
            formData.append('text', newContent);
            formData.append('userid', userID);
            formData.append('description', description);

            if (fileInput.files.length > 0) {
                formData.append('filename', fileInput.files[0]);
            }

            savePostEdit(formData).then( ()=>{
                removeOverlay();
                window.location.reload();
            })

        });
}

// hämtar all data som finns på posten så vi kan visa det för användaren
// finns i dbGrejer/apiGrejsenFragetecken.php på rad 51
// finns i dbGrejer/apiGrejsenFragetecken.php på rad 51
window.getPostText = async function(id){
    try{
        const response = await fetch(`${API_BASE}?id=${id}&text=true`,{
            method: 'GET',
        })
        if (!response.ok) {
            throw new Error('nånting gick fel');
        } else {
            console.log('hämtade texten normalt typ');
        }
        return await response.json();

    }catch (e){
        console.log('error hämta text', e);
    }
}

// sparar datan som användaren har skrivit in i posten
// om edit == true => att det är en redigering av en existerande post
// finns i dbGrejer/apiGrejsenFragetecken.php på rad 92
// finns i dbGrejer/apiGrejsenFragetecken.php på rad 92
window.savePostEdit = async function(formData, edit= false){
    console.log(formData);

    try {
        const response = await fetch(`${API_BASE}?savepost=true&edit=${edit}`,{
            method:'POST',
            body: formData
        });
        if (!response.ok) {
            throw new Error('nånting gick fel');
        } else {
            console.log('sparade typ normalt eller något');
        }
        return await response.json;
    }catch (e){
        console.log('nånting error spara postedit')
    }
}