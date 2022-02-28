<template>
  <div class="container">
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
      </div>
      <div class="container_right">
        <div class="details" v-for="groupe in groupes" :key="groupe.id">
          <img :src="groupe.avatar_urls.full" alt="Groupe Logo" />
          <div class="nom">{{ groupe.name }}</div>
          <div class="description">{{ groupe.description.raw }}</div>
        </div>
        <hr />
        <div class="pub"></div>
      </div>
    </div>
  </div>
</template>

<script>
import NavBar from "@/components/NavBar.vue";
export default {
   name: "app",
  components: {
    NavBar,
  },
  data() {
    return {
      UserName,
      UserSlug,
      UserID,
      token,
      password,
      groupes: [],
      activities: [],
      deconnexion,
    };
  },
  methods: {
    getGroupes() {
      fetch(
        "http://localhost:8005/wp-json/buddypress/v1/groups/" +
          this.$route.params.id
      )
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
          console.log(activities);
          this.activities = activities;
        });
    },
  },
  mounted() {
    this.getGroupes();
    this.getactivities();
  },
};

const token = localStorage.getItem("token");
const UserID = localStorage.getItem("UserID");
const UserSlug = localStorage.getItem("UserSlug");
const UserName = localStorage.getItem("UserName");
const password = localStorage.getItem("password");

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
</script>

<style scoped>
.description {
  font-size: 18px;
}
.nom {
  text-transform: capitalize;
  font-size: 20px;
  color: #0066cc;
  margin: 20px;
}
.details {
  margin: 20px;
  margin-left: auto;
  margin-right: auto;
  width: 100%;
}
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
</style>
