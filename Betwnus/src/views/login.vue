<template>
  <div class="container">
    <div class="header"></div>
    <div class="formulaire">
      <h1>LOGIN</h1>
      <img src="../assets/avatar.png" alt="avatar" />
      <form class="form" method="post" @submit="getUser">
        <h3>Username</h3>
        <input id="username" type="text" required />
        <h3>Password</h3>
        <input id="password" type="password" required />
        <div class="remember">
          <input class="checkbox" required type="checkbox" /> Remember me
        </div>

        <button class="login_button" type="submit">Login</button>
      </form>
      <div class="register_test">
        Create a new acount
        <router-link to="/register" style="text-decoration: none"
          >here</router-link
        >
      </div>
    </div>

    <div id="myModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <div id="response">Please enter valid credentials</div>
      </div>
    </div>
  </div>
</template>

<script>
// import axios from "axios";
export default {
  methods: {
    getUser(e) {
      e.preventDefault();
      var username = document.querySelector("#username").value;
      var password = document.querySelector("#password").value;

      var userData = {
        username: username,
        password: password,
      };
      // recuperation du token
      var authRequest = new XMLHttpRequest();

      authRequest.open(
        "POST",
        "http://localhost:8005/wp-json/jwt-auth/v1/token"
      );
      authRequest.setRequestHeader("Content-Type", "application/json");
      authRequest.setRequestHeader("Accept", "application/json");
      authRequest.send(JSON.stringify(userData));
      authRequest.onreadystatechange = function () {
        if (authRequest.readyState == 4) {
          //   console.log(authRequest.responseText);
          var authJson = JSON.parse(authRequest.responseText);
          var token = authJson.token;

          // connexion et recuperation de l'id de l'utilisateur dont le nom et le mot de passe sont entrés

          fetch("http://localhost:8005/wp-json/wp/v2/users/me", {
            method: "GET",
            userData,
            headers: {
              Authorization: "Bearer " + token,
              "Content-Type": "application/json",
              Accept: "application/json",
            },
          }).then(async (response) => {
            try {
              const data = await response.json();
              stockage(data, token);
            } catch (error) {
              console.log("Error happened here!");
              console.error(error);
            }
          });
        }
      };
      // Enregistrement en local des informations provenant de l'api
      function stockage(data, token) {
        console.log(data);
        var UserID = data.id;
        var UserName = data.name;
        var UserSlug = data.slug;
        var UserDescription = data.description;
        var avatar_urls = data.avatar_urls[96];
        var password = document.querySelector("#password").value;

        localStorage.setItem("token", token);
        localStorage.setItem("UserID", UserID);
        localStorage.setItem("UserName", UserName);
        localStorage.setItem("UserSlug", UserSlug);
        localStorage.setItem("UserDescription", UserDescription);
        localStorage.setItem("password", password);
        localStorage.setItem("avatar_urls", avatar_urls);
        redirect(data);
      }
      // apres verification des informations de connexion
      function redirect(data) {
        if (
          localStorage.getItem("token") !== "undefined" &&
          localStorage.getItem("token") !== null
        ) {
          console.log("gael");
          window.location.href =
            window.location.origin + `/dashboard/${data.id}`;
        } else {
          var modal = document.getElementById("myModal");
          var span = document.getElementsByClassName("close")[0];

          modal.style.display = "block";
          span.onclick = function () {
            modal.style.display = "none";
          };
        }
      }
    },
  },
};
</script>

<style scoped>
* {
  margin: 0;
  background-color: white;
}
/* .container {
} */

.header {
  width: 100%;
  height: 100px;
  background-color: #0066cc;
  box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px,
    rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
}
.header > img {
  height: 90px;
  width: 100px;
}

.formulaire {
  width: 450px;
  margin: auto;
  padding: 20px;
  box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
  height: 550px;
  margin-top: 50px;
}

.formulaire > img {
  margin-top: 30px;
  width: 100px;
  margin-left: auto;
  margin-right: auto;
}

h1,
h3 {
  color: #0066cc;
}

form {
  margin-top: 50px;
}

.form {
  display: grid;
}

input {
  width: 300px;
  height: 30px;
  border-radius: 5px;
  margin: auto;
  margin-bottom: 20px;
  margin-top: 20px;
  font-size: 18px;
}

.login_button {
  width: 100px;
  height: 35px;
  border-radius: 5px;
  background-color: #0066cc;
  font-size: 20px;
  color: white;
  margin: auto;
  margin-top: 20px;
  cursor: pointer;
}

.remember {
  width: 300px;
  display: flex;
  margin: auto;
}

.checkbox {
  width: 15px;
  height: 15px;
  margin: 0;
  margin-right: 10px;
}

.register_test {
  margin-top: 20px;
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
</style>
