<template>
  <div class="container">
    <NavBar />
    <div class="body">
      <div class="container_left">
        <div class="picture">
          <img :src="avatar_urls" alt="profile picture" class="avatar" />
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
          <router-link to="" class="lien" @click="DisplayForm" id="create"
            >Créer un post</router-link
          >
          <router-link to="/list_groupes" class="lien">Groupes</router-link>
          <router-link style="display: flex" to="" class="lien"
            >Notifications
            <div class="nbrnotif"></div
          ></router-link>
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
        <div class="formulaire">
          <span class="close">&times;</span>
          <div class="formulaire_container">
            <textarea id="title" placeholder="Titre"></textarea
            ><editor
              v-model="editor"
              aria-placeholder="contenu"
              initialValue="<p>Initial editor content</p>"
              apiKey="9d8obghi4sokqeq4jp6ulagj1cr0thhv9uzvoark11y2zbon"
              :init="{
                height: 700,
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

            <button id="createpost" @click="createPost">Créer</button>
          </div>
        </div>

        <div class="container_post" v-for="post in posts" :key="post.id">
          <h2>{{ post.title.rendered }}</h2>
          <div v-html="post.content.rendered" class="html"></div>

          <div class="post_action">
            <div class="like_div">
              <img src="../assets/like.png" alt="like" class="like" />
              <div class="nombre_de_like"></div>
            </div>
            <button @click="del(post.id, post.author)" class="supprimer">
              Supprimer
            </button>
          </div>
        </div>
      </div>
    </div>
    <div id="myModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <div id="response"></div>
      </div>
    </div>
  </div>
</template>

<script>
import NavBar from "@/components/NavBar.vue";
import Editor from "@tinymce/tinymce-vue";
import { mapActions, mapGetters } from "vuex";
export default {
  name: "app",
  components: {
    editor: Editor,
    NavBar,
  },
  computed: {
    ...mapGetters(["posts"]),
  },
  methods: {
    ...mapActions(["fetchAllposts"]),
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
          var nbrnotif = document.querySelector(".nbrnotif");
          var nbr = `<div style="margin-left:10px; border-radius:50%; background-color:#0066cc; width:20px; height:20px; text-align:center; color:white; font-weight:bold">${myactivity.length}</div>`;
          nbrnotif.insertAdjacentHTML("beforeend", nbr);
        });
    },
  },
  created() {
    this.fetchAllposts();
  },
  data() {
    return {
      UserName,
      UserSlug,
      UserID,
      token,
      DisplayForm,
      createPost,
      del,
      categories,
      deconnexion,
      editor: "",
      activities: [],
      avatar_urls,
      // notifs,
    };
  },
  mounted() {
    this.getactivities();
  },
};
const token = localStorage.getItem("token");
const UserID = localStorage.getItem("UserID");
const UserSlug = localStorage.getItem("UserSlug");
const UserName = localStorage.getItem("UserName");
const avatar_urls = localStorage.getItem("avatar_urls");

function deconnexion() {
  localStorage.removeItem("token");
  localStorage.removeItem("UserID");
  localStorage.removeItem("UserName");
  localStorage.removeItem("UserSlug");
  localStorage.removeItem("UserDescription");
  localStorage.removeItem("UserAvatar_url");
  localStorage.removeItem("data.postes");
  localStorage.removeItem("postes");
  localStorage.removeItem("avatar_urls");
  localStorage.removeItem("password");
}

function categories() {
  fetch("http://localhost:8005/wp-json/wp/v2/categories")
    .then((Response) => {
      return Response.json();
    })
    .then((categories) => {
      console.log(categories);
      select(categories);
    });
}

function select(categories) {
  for (var i = 0; i < categories.length; i++) {
    var select = document.querySelector("#select");
    var option = `<option value="${categories[i].name}">${categories[i].name}</option>`;
    select.insertAdjacentHTML("beforeend", option);
  }
}

// afficher le formulaire de creation de post

function DisplayForm() {
  var formulaire = document.querySelector(".formulaire");
  var close = document.querySelector(".close");

  formulaire.style.display = "block";
  close.onclick = function () {
    formulaire.style.display = "none";
  };
}

// creation de posts
function createPost() {
  var title = document.querySelector("#title").value;
  var content = this.editor;

  console.log(title);
  console.log(content);

  var data = {
    title: title,
    content: content,
    status: "publish",
    author: UserID,
    comment_status: "open",
    format: "standard",
  };
  var createPostRequest = new XMLHttpRequest();
  createPostRequest.open("POST", "http://localhost:8005/wp-json/wp/v2/posts");
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

// suppression de posts
function del(id, author) {
  console.log(author);
  console.log(id);
  console.log(UserID);
  if (author == UserID) {
    fetch("http://localhost:8005/wp-json/wp/v2/posts/" + id, {
      method: "DELETE",
      headers: {
        Authorization: "Bearer " + token,
      },
    })
      .then((res) => res.json())
      .then((res) => {
        console.log(res);
        location.reload();
      });
  } else {
    console.log("you're not allowed to perform this action");
    var responseDiv = document.getElementById("response");
    var modal = document.getElementById("myModal");
    var span = document.getElementsByClassName("close")[0];
    modal.style.display = "block";
    responseDiv.innerHTML =
      '<h4 style="color:red">You are not allowed to perform this action </h4>';
    span.onclick = function () {
      modal.style.display = "none";
    };
  }
}
</script>

<style scoped>
*,
body {
  margin: 0;
  background-color: white;
}
.container {
  width: 100%;
  display: grid;
}
.body {
  width: 100%;
  display: flex;
  justify-content: space-between;
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

.header > img {
  height: 100px;
  width: 120px;
}

.container_right {
  margin-right: 15px;
  width: 80%;
  min-height: 820px;
  box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px,
    rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
  margin-left: 20%;
  margin-top: 120px;
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

.username > h2 {
  margin-top: 15px;
  margin-bottom: 15px;
  text-transform: capitalize;
}

.connexion {
  width: 10px;
  position: absolute;
  top: 150px;
  left: 10%;
  display: none;
}
.formulaire {
  width: 40%;
  margin: auto;
  box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px,
    rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
  margin-bottom: 20px;
  margin-top: 20px;
  padding: 15px;
  text-align: center;
  display: none;
  position: fixed;
  margin-left: 20%;
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

.container_post {
  width: 40%;
  margin: auto;
  box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px,
    rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
  margin-bottom: 20px;
  margin-top: 20px;
  padding: 15px;
  text-align: center;
}

.container_post > h2 {
  margin: 20px;
  text-transform: capitalize;
}

.html {
  text-align: justify;
}

.supprimer {
  margin-left: 80%;
  cursor: pointer;
  background-color: #0066cc;
  color: white;
  height: 35px;
  border-radius: 5px;
  font-weight: bold;
  width: 30%;
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

.formulaire_container {
  display: grid;
}

#title {
  height: 50px;
  width: 60%;
  margin: auto;
  margin-bottom: 20px;
  border: 1px solid;
  font-size: 18px;
}

#content {
  height: 150px;
  width: 60%;
  margin: auto;
  margin-bottom: 20px;
  border: 1px solid;
  font-size: 18px;
}

#createpost {
  height: 40px;
  width: 100px;
  font-size: 20px;
  background-color: #0066cc;
  color: white;
  margin: auto;
  cursor: pointer;
}

.like {
  height: 15px;
  cursor: pointer;
}

.like_div {
  margin-top: 15px;
  display: flex;
}

.like_div > img {
  margin-right: 5px;
}
.post_action {
  display: flex;
  justify-content: space-between;
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
