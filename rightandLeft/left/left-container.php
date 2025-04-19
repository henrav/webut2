<?php

$newUsers = get_newest_users(10);

$tf2quotes = array(
    "Need a dispenser here!",
    "Need a Sentry here!",
    "Say goodbye to your kneecaps, chucklehead",
    "Im the Scout here!",
    "Oh they're gonna have to glue you back together, in hell!",
    "I'm not even winded!",
    "Maggots!",
    "Cry some more!",
    "Nope.",
    "I am ze Ubermensch!",
    "Mmmph!",
    "Boom. Headshot.",
    "Right behind you.",
    "KA-BOOM!",
    "Play ball!",
    "Thanks for standing still, wanker!",
    "God save the Queen!",
    "Stand... on... the... point! Numbnuts!",
    "If God had wanted you to live, He would not have created me!",
    "Take it like a man, shorty.",
    "The healing leaves little time for the hurting.",
    "Push little wagon!",
    "I appear to have burst into flames.",
    "I do believe I'm on fire.",
    "Man, losing is stupid!",
    "Last one didn't count! Just a warmup!",
    "Ties are stupid!",
    "Dominated, string-bean.",
    "Shoot, son, y'all slow as molasses.",
    "Gotcha, stretch!",
    "You run fast, my bullets run faster.",
    "Less talk, more fight.",
    "Never bring a bat to a battlefield, war is not a game.",
    "I killed the bloody Loch Ness Monster! I ain't afraid of six wee men!",
    "Let's push 'em back to spawn, lads!",
    "Bear down, lads! Let's finish it!",
    "All of you are dead!",
    "What sick man sends babies to fight me?",
    "Everyone! Behind me!",
    "No robot shall pass!",
    "I don't make the first move, just the last one.",
    "Never complain, never explain, aim for the brain.",
    "Be advised, the control point is being captured!",
    "Spy sappin' my sentry!",
    "Who touches my sandvich, dies!",
    "Not so fast, asshole!",
    "Airstrike!",
    "Heads up!",
    "Cover me!",
    "Area denial!",
    "Let's dance!",
    "Good thing I'm wearing two hats.",
    "Some people think they can outsmart bullet. Maybe… maybe. I have yet to meet one that can outsmart a bullet.",
    "Grass grows, birds fly, sun shines, and brother, I hurt people.",
    "I’m gonna headbutt ya! I’m gonna headbutt ya! I’m gonna headbutt ya!",
    "Wave goodbye to your secret crap, dumbass!",
    "Where’s your precious Hippo‑Crates now?",
    "I am Heavy Weapons Guy, and this is my weapon.",
    "Promise not to bleed on my suit and I’ll kill you quickly.",
    "I’m going to gut you like a Cornish game hen.",
    "SCOTLAND IS NOT A REAL COUNTRY, YOU ARE JUST AN ENGLISHMAN IN A DRESS",
    "I HAVE RETURNED FROM THE GRAVE TO GIVE THE LIVING HAIRCUT!",
    "So that's it? What, we some kind of Team Fortress 2?",
    "I didn't mean to hit ya, oh wait yeah I did",
    "Words can not express how much I HATE France right now!",
    "Go on and build more o' yer little guns. I'll shove every one of them up yer arse!",
    "Would you like a second opinion...? YOU ARE ALSO UGLY!",
    "Nyeeeeeehh.",
    "Think fast, chucklenuts!",
    "Well, off to visit your mother!",
    "POOTIS POW",
    "I WILL SEND MY CONDOLENCES TO YOUR KANGAROO WIFE!",
    "I AM HAVING A HEART ATTACK",
    "HAHAHAHA YOU LIVE IN A VAN HAHAHAHAHA",
    "If you were huntin' trouble, lad, ya found it.",
    "I will eat your ribs. I will eat them up!"
);

shuffle($tf2quotes);


?>

<div class="main-body-left">
    <div class="left-main-content">
        <div style="color: black" class="news-feed">
            <h2 style="color: black; margin: 0; background-color: #f6f6f6; padding: 20px 60px; border-radius: 6px">
                Nyaste medlemmar
            </h2>
            <!-- orka inte göra en klass för detta som för posten-->
         <?php
            foreach ($newUsers as $post) {
                // separerar posts från nya users genom att
                // selecta "ID" as "userID" när jag hämtar users
                // hade nya posts här innan därflr det är en if sats men kl äär 01 och orkar inte ta bort
                if (isset($post['userID'])){
                    $imgPath = ! empty($post['image'])
                        ? $post['image']
                        : 'images/Heavy_from_tf2 copy.png';
                    $randomQuote = array_pop($tf2quotes);
                    echo    '<div class="ny-user">
                                   <h3>Ny heavy joina oss</h3>
                                   <div class="ny-text-container">
                                             <div class="ny-user-text">välkommna</div>
                                             <div class="ny-user-name">'.$post['username'] .'</div>    
                                    </div>
                                    <div style="font-style: italic;">
                                       "'. $randomQuote .'"
                                    </div>
                                 
                                <div class="ny-user-container">
                                        <div class="ny-user-img">
                                  
                                        <img class="ny-user-img" src="/'.$imgPath .'" alt="">
                                    </div>
                                    <div class="ny-user-timestamp">'.$post['created'] . '</div>
                                </div>
                            </div>';
                }
            }
         ?>
        </div>
    </div>

</div>
