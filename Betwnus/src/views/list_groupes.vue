<template>
  <div class="container">
    <!-- <div class="header"></div> -->
    <NavBar />
    <div class="body">
      <div class="container_left">
        <div class="picture">
          <img
            src="../assets/avatar.png"
            alt="profile picture"
            class="avatar"
          />
          <img
            src="../assets/connexion.svg"
            alt="profile picture"
            class="connexion"
          />
        </div>
        <div class="username">
          <h2>{{ UserName }}</h2>
        </div>
        <div class="action">
          <router-link to="/dashboard/+ {{ UserID }}" class="lien"
            >Accueil</router-link
          >
          <router-link
            :to="{ name: 'profile', params: { id: UserID } }"
            class="lien"
            >Profil</router-link
          >
          <router-link to="/list_groupes" class="lien">Groupes</router-link>
          <router-link to="" class="lien">Notifications</router-link>
          <!-- <router-link to="" class="lien">Messages</router-link> -->
          <router-link to="/login" class="lien" @click="deconnexion"
            >Déconnexion</router-link
          >
        </div>
        <div class="activity">Mes activités</div>
        <div
          class="contenu_activite"
          v-for="activity in activities"
          :key="activity.id"
        >
          <div class="date">{{ activity.date }}</div>
          <div class="titre" v-html="activity.title"></div>
        </div>
      </div>
      <div class="container_right">
        <button @click="formgroup" class="creation_groupe">Nouveau</button>
        <div class="groupes" v-for="groupe in groupes" :key="groupe.id">
          <h2>{{ groupe.name }}</h2>
          <router-link :to="{ name: 'groupe', params: { id: groupe.id } }">
            <button class="rejoindre">Voir</button></router-link
          >
        </div>
      </div>
      <div id="myModal" class="modal">
        <div class="modal-content">
          <span class="close">&times;</span>
          <div class="form">
            <h3>Nom du groupe</h3>
            <textarea class="nom" type="text" required />

            <h3>Description du groupe</h3>
            <editor
              v-model="editor"
              initialValue="<p>Initial editor content</p>"
              apiKey="9d8obghi4sokqeq4jp6ulagj1cr0thhv9uzvoark11y2zbon"
              :init="{
                height: 1000,
                menubar: false,
                plugins: [
                  'advlist autolink lists link image charmap',
                  'searchreplace visualblocks code fullscreen',
                  'print preview anchor insertdatetime media',
                  'paste code help wordcount table',
                  'emoticons autoresize',
                ],
                toolbar:
                  'undo redo | formatselect | bold italic | \
        alignleft aligncenter alignright | \
        bullist numlist outdent indent | emoticons | help',
              }"
            >
            </editor>
            <!-- <textarea class="description" type="text" required /> -->
            <button @click="creategroupe" class="submit">Créer</button>
          </div>
        </div>
      </div>
      <div id="myModal1" class="modal1">
        <div class="modal-content1">
          <span class="close1">&times;</span>
          Email<input type="text" id="Emaildeconf" required />
          <button @click="buddyUser">Valider</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import NavBar from "@/components/NavBar.vue";
import Editor from "@tinymce/tinymce-vue";
export default {
  name: "app",
  components: {
    editor: Editor,
    NavBar,
  },
  data() {
    return {
      UserName,
      UserSlug,
      UserID,
      token,
      password,
      deconnexion,
      groupes: [],
      activities: [],
      formgroup,
      creategroupe,
      modal,
      buddyUser,
      editor: "",
    };
  },
  methods: {
    getGroupes() {
      fetch("http://localhost:8005/wp-json/buddypress/v1/groups")
        .then((Response) => {
          return Response.json();
        })
        .then((groupes) => {
          this.groupes = groupes;
        });
    },

    getactivities() {
      fetch("http://localhost:8005/wp-json/buddypress/v1/activity")
        .then((Response) => {
          return Response.json();
        })
        .then((activities) => {
          var myactivity = [];
          for (var i = 0; i < activities.length; i++) {
            if (activities[i].user_id == UserID) {
              myactivity.push(activities[i]);
            }
          }
          this.activities = myactivity;
        });
    },
  },
  mounted() {
    this.getGroupes();
    this.getactivities();
  },
};

function formgroup() {
  var modal = document.getElementById("myModal");
  var span = document.getElementsByClassName("close")[0];

  modal.style.display = "block";
  span.onclick = function () {
    modal.style.display = "none";
  };
}

const token = localStorage.getItem("token");
const UserID = localStorage.getItem("UserID");
const UserSlug = localStorage.getItem("UserSlug");
const UserName = localStorage.getItem("UserName");
const password = localStorage.getItem("password");

function modal() {
  // console.log("gehze");
  var modal1 = document.getElementById("myModal1");
  var span1 = document.getElementsByClassName("close1")[0];

  modal1.style.display = "block";
  span1.onclick = function () {
    modal1.style.display = "none";
  };
}

function creategroupe() {
  // console.log(UserID);

  var name = document.querySelector(".nom").value;
  // var description = document.querySelector(".description").value;
  var description = this.editor;
  var creator_id = UserID;
  // console.log(editor);

  var data = {
    name: name,
    description: description,
    creator_id: creator_id,
  };
  var createPostRequest = new XMLHttpRequest();
  createPostRequest.open(
    "POST",
    "http://localhost:8005/wp-json/buddypress/v1/groups"
  );
  createPostRequest.setRequestHeader("Authorization", "Bearer " + token);
  createPostRequest.setRequestHeader("Content-Type", "application/json");
  createPostRequest.setRequestHeader("Accept", "application/json");
  createPostRequest.send(JSON.stringify(data));
  createPostRequest.onreadystatechange = function () {
    if (createPostRequest.readyState == 4) {
      console.log("success");
      location.reload();
    }
  };
}

function deconnexion() {
  localStorage.removeItem("token");
  localStorage.removeItem("UserID");
  localStorage.removeItem("UserName");
  localStorage.removeItem("UserSlug");
  localStorage.removeItem("UserDescription");
  localStorage.removeItem("UserAvatar_url");
  localStorage.removeItem("data.postes");
  localStorage.removeItem("postes");
  localStorage.removeItem("password");
  localStorage.removeItem("avatar_urls");
}

function buddyUser() {
  var email = document.querySelector("#Emaildeconf").value;
  var data = {
    user_login: UserName,
    password: password,
    email: email,
  };
  var createbuddyUser = new XMLHttpRequest();
  createbuddyUser.open(
    "POST",
    "http://localhost:8005/wp-json/buddypress/v1/members"
  );
  createbuddyUser.setRequestHeader("Authorization", "Bearer " + token);
  createbuddyUser.setRequestHeader("Content-Type", "application/json");
  // createbuddyUser.setRequestHeader("Accept", "application/json");
  createbuddyUser.send(JSON.stringify(data));
  createbuddyUser.onreadystatechange = function () {
    if (createbuddyUser.readyState == 4) {
      console.log("success");
    }
  };
}
</script>

<style scoped>
.container {
  width: 100%;
  display: grid;
}
.header {
  width: 100%;
  height: 100px;
  background-color: #0066cc;
  box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px,
    rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
  margin-bottom: 20px;
  position: fixed;
}

.body {
  width: 100%;
  display: flex;
  justify-content: space-between;
}

.container_left {
  width: 15%;
  height: 820px;
  box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px,
    rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
  position: fixed;
  margin-top: 120px;
  margin-left: 15px;
}

.avatar {
  width: 30%;
  margin-top: 20px;
}

.connexion {
  width: 10px;
  position: absolute;
  top: 150px;
  left: 10%;
  display: none;
}

.username > h2 {
  margin-top: 15px;
  margin-bottom: 15px;
  text-transform: capitalize;
}

.action {
  display: grid;
  text-align: left;
  padding: 10px;
  border-bottom: 1px solid;
}

.lien {
  text-decoration: none;
  margin-bottom: 20px;
}

.container_right {
  margin-right: 15px;
  width: 80%;
  min-height: 820px;
  box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px,
    rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
  margin-left: 20%;
  margin-top: 120px;
  padding-left: 20px;
  padding-right: 20px;
}

.groupes {
  display: flex;
  justify-content: space-between;
}

.groupes > h2 {
  text-transform: capitalize;
  color: #0066cc;
}

.rejoindre {
  height: 40px;
  width: 150px;
  margin-top: 25px;
  background-color: #0066cc;
  cursor: pointer;
  color: white;
  font-size: 18px;
  font-weight: bold;
}

.creation_groupe {
  height: 40px;
  width: 150px;
  margin-top: 25px;
  background-color: #0066cc;
  cursor: pointer;
  color: white;
  font-size: 18px;
  font-weight: bold;
}

.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0, 0, 0);
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
.nom {
  height: 40px;
  width: 40%;
  margin: auto;
  font-size: 18px;
}

.description {
  height: 80px;
  width: 40%;
  margin: auto;
  font-size: 18px;
}

.form {
  display: grid;
}

.submit {
  height: 40px;
  width: 150px;
  margin-top: 25px;
  background-color: #0066cc;
  cursor: pointer;
  color: white;
  font-size: 18px;
  font-weight: bold;
  margin-left: auto;
  margin-right: auto;
}

.modal1 {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0, 0, 0);
  background-color: rgba(0, 0, 0, 0.4);
}

.modal-content1 {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
}

.close1 {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close1:hover,
.close1:focus {
  color: #0066cc;
  text-decoration: none;
  cursor: pointer;
}

.activity {
  margin-top: 20px;
  color: #0066cc;
  font-size: 20px;
  font-weight: bold;
}

.contenu_activite {
  margin-top: 20px;
}

.titre {
  text-align: justify;
  padding: 5px;
  text-decoration: none;
}
</style>
