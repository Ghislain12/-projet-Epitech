<template>
  <div class="container">
    <!-- <div class="header"></div> -->
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
      </div>

      <div class="container_right">
        <div class="entete">Mes informations</div>
        <div class="user">
          <div class="picture_profile">
            <img :src="avatar_urls" alt="profile picture" class="user_avatar" />
          </div>
          <div class="nom">
            Nom:
            <div class="nom_valeur">{{ UserName }}</div>
          </div>
          <div class="slug">
            Surnom:
            <div class="nom_valeur">{{ UserSlug }}</div>
          </div>
          <div class="id">
            ID:
            <div class="nom_valeur">{{ UserID }}</div>
          </div>
          <div class="description">
            Description:
            <div class="nom_valeur">{{ description }}</div>
          </div>
          <div class="bas">
            <button class="editer_profil" @click="editer">Editer</button>
            <button @click="delUser(UserID)" class="supprimer_profil">
              Supprimer
            </button>
          </div>
        </div>
        <div id="myModal" class="modal">
          <div class="modal-content">
            <span class="close">&times;</span>
            <div class="form">
              <h3>Nom</h3>
              <textarea
                class="nom"
                type="text"
                v-model="nom"
                :placeholder="UserName"
              />

              <h3>Surnom</h3>
              <textarea
                class="nom"
                type="text"
                v-model="surnom"
                :placeholder="UserSlug"
              />
              <h3>Avatar</h3>
              <input class="file" type="file" />

              <h3>Description</h3>

              <editor
                v-model="editor"
                initialValue="<p>Initial editor content</p>"
                apiKey="9d8obghi4sokqeq4jp6ulagj1cr0thhv9uzvoark11y2zbon"
                :placeholder="description"
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
              <button @click="modifierpro" class="submit">Modifier</button>
            </div>
          </div>
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
      avatar_urls,
      description,
      deconnexion,
      infos: [],
      editer,
      modifierpro,
      nom: "",
      surnom: "",
    };
  },
  methods: {
    getinfos() {
      fetch("http://localhost:8005/wp-json/wp/v2/users/" + UserID, {
        headers: {
          Authorization: "Bearer " + this.token,
        },
      })
        .then((Response) => {
          return Response.json();
        })
        .then((infos) => {
          console.log(infos);
          this.infos = infos;
        });
    },
    delUser(UserID) {
      fetch("http://localhost:8080/wp-json/wp/v2/users/" + UserID, {
        headers: {
          methods: "DELETE",
          Authorization: "Bearer " + this.token,
        },
      })
        // .then((response) => {
        //   return response.json();
        // })
        .then((response) => {
          console.log(response);
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },

  mounted() {
    this.getinfos();
  },
};
const token = localStorage.getItem("token");
const UserID = localStorage.getItem("UserID");
const UserSlug = localStorage.getItem("UserSlug");
const UserName = localStorage.getItem("UserName");
const avatar_urls = localStorage.getItem("avatar_urls");
const description = localStorage.getItem("UserDescription");

function modifierpro() {
  var file = document.querySelector(".file").value;
  console.log(file);

  var data = {
    username: this.nom,
    description: this.editor,
    slug: this.surnom,
    avatar_urls: file,
  };
  var createPostRequest = new XMLHttpRequest();
  createPostRequest.open(
    "POST",
    "http://localhost:8005/wp-json/wp/v2/users/" + UserID
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
  localStorage.removeItem("avatar_urls");
  localStorage.removeItem("password");
}

function editer() {
  var modal = document.getElementById("myModal");
  var span = document.getElementsByClassName("close")[0];

  modal.style.display = "block";
  span.onclick = function () {
    modal.style.display = "none";
  };
}
</script>

<style scoped>
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

.user_avatar {
  width: 15%;
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
.action {
  display: grid;
  text-align: left;
  padding: 10px;
}

.lien {
  text-decoration: none;
  margin-bottom: 20px;
}

.entete {
  margin: 20px;
  color: #0066cc;
  font-weight: bold;
  font-size: 20px;
  text-transform: capitalize;
}

.nom {
  display: flex;
  justify-content: space-between;
  color: #0066cc;
  font-size: 20px;
  font-weight: bold;
  margin-top: 15px;
}

.slug {
  display: flex;
  justify-content: space-between;
  color: #0066cc;
  font-size: 20px;
  font-weight: bold;
  margin-top: 15px;
}

.id {
  display: flex;
  justify-content: space-between;
  color: #0066cc;
  font-size: 20px;
  font-weight: bold;
  margin-top: 15px;
}
.description {
  display: flex;
  justify-content: space-between;
  color: #0066cc;
  font-size: 20px;
  font-weight: bold;
  margin-top: 15px;
}
.user {
  width: 40%;
  margin: auto;
  padding: 15px;
}
.bas {
  display: flex;
  justify-content: space-between;
}

.editer_profil {
  padding: 10px;
  cursor: pointer;
  background-color: #0066cc;
  color: white;
  height: 35px;
  border-radius: 5px;
  font-weight: bold;
  margin-top: 15px;
}

.supprimer_profil {
  padding: 10px;
  cursor: pointer;
  background-color: red;
  color: white;
  height: 35px;
  border-radius: 5px;
  font-weight: bold;
  margin-top: 15px;
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
</style>
