<template>
  <div class="header">
    <div class="nav">
      <img id="logo" src="../assets/logo.png" alt="logo" />
      <input id="search" placeholder="Search" />
      <button @click="tologin()" id="login">Déconnexion</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "HelloWorld",
  props: {
    msg: String,
  },
  methods: {
    tologin() {
      this.$router.push({ path: "/login" });
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
    },
    toregister() {
      this.$router.push({ path: "/register" });
    },
    tohome() {
      this.$router.push({ path: "/dashboard/+ {{ UserID }}" });
    },
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.header {
  background-color: rgb(2, 2, 150);
  width: 100%;
  height: auto;
  padding: 10px;
  padding-top: 0;
  margin: auto auto;
}

.nav {
  display: flex;
  flex-wrap: nowrap;
  justify-content: space-between;
  text-align: center;
}

button,
#search {
  cursor: pointer;
  background-color: white;
  color: rgb(2, 2, 150);
  border: none;
  border-radius: 5px;
  box-shadow: 2px;
  width: 8%;
  height: 35px;
  font-size: 100%;
  margin-top: 2%;
  margin-right: 2%;
}

button:hover {
  background-color: lightblue;
}

#logo {
  width: 15%;
}

#search {
  width: 25%;
  border-radius: 0;
  background-color: whitesmoke;
  box-shadow: inset 0px 0px 0px 2px rgb(255, 153, 0);
}
</style>
