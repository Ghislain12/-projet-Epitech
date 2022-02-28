<template>
  <div class="container">
    <div class="header">
      <!-- <router-link to="/">retour</router-link>
      <router-link to="/login">login</router-link>
      <router-link to="/register">register</router-link> -->
    </div>
    <div class="formulaire">
      <h1>REGISTER</h1>
      <img src="../assets/avatar.png" alt="avatar" />
      <form class="form" method="post" @submit="createUser">
        <h3>Username</h3>
        <input id="username" type="text" required />
        <h3>Email</h3>
        <input id="email" type="email" required />
        <h3>Password</h3>
        <input id="password" type="password" required />
        <img
          class="validation2"
          src="../assets/validation.webp"
          alt="validation"
        />
        <h3>Confirm your Password</h3>
        <input id="passwordconf" type="password" required />
        <img
          class="validation1"
          src="../assets/validation.webp"
          alt="validation"
        />
        <button class="register_button" type="submit">Register</button>
      </form>
      <div class="login_test">
        Login
        <router-link to="/login" style="text-decoration: none"
          >here</router-link
        >
      </div>
    </div>

    <div id="myModal" class="modal">
      <div class="modal-content">
        <span class="close">&times;</span>
        <div id="response"></div>
        <p>
          Now you can login
          <router-link to="/login" style="text-decoration: none"
            >here</router-link
          >
        </p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    createUser(e) {
      e.preventDefault();
      var username = document.querySelector("#username").value;
      var email = document.querySelector("#email").value;
      var password = document.querySelector("#password").value;
      var passwordconf = document.querySelector("#passwordconf").value;
      var modal = document.getElementById("myModal");
      var span = document.getElementsByClassName("close")[0];
      var validation1 = document.querySelector(".validation1");
      var validation2 = document.querySelector(".validation2");

      if (password == passwordconf) {
        validation1.style.display = "block";
        validation2.style.display = "block";
        var ourUserDAta = {
          username: username,
          email: email,
          password: password,
        };

        var userData = {
          username: "gael",
          password: "gael",
        };

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
            var authJson = JSON.parse(authRequest.responseText);
            var token = authJson.token;
            console.log(token);

            var createUser = new XMLHttpRequest();

            var responseDiv = document.getElementById("response");

            createUser.open(
              "POST",
              "http://localhost:8005/wp-json/wp/v2/users"
            );
            createUser.setRequestHeader("Authorization", "Bearer " + token);
            createUser.setRequestHeader(
              "Content-Type",
              "application/json;charset:UTF-8"
            );
            createUser.send(JSON.stringify(ourUserDAta));
            createUser.onreadystatechange = function () {
              if (createUser.readyState == 4) {
                if (createUser.status == 201) {
                  modal.style.display = "block";
                  responseDiv.innerHTML =
                    '<h4 style="color:green">Account create successfully ! </h4>';
                  span.onclick = function () {
                    modal.style.display = "none";
                  };
                  var userJson = JSON.parse(createUser.responseText);
                  var id = userJson.id;
                  return id;
                } else {
                  responseDiv.innerHTML =
                    '<h4 style="color:red">Réessayer !</h4>';
                }
              }
            };
          }
        };
      } else {
        var responseDiv = document.getElementById("response");
        modal.style.display = "block";
        responseDiv.innerHTML =
          '<h4 style="color:green">Confirm your password ! </h4>';
        span.onclick = function () {
          modal.style.display = "none";
        };
      }
    },
  },
};

// function buddypressUser(token) {
//   var user_login = document.querySelector("#username").value;
//   var email = document.querySelector("#email").value;
//   var password = document.querySelector("#password").value;

//   var ourBuddyDAta = {
//     user_login: user_login,
//     email: email,
//     password: password,
//   };

//   var createUserBuddy = new XMLHttpRequest();
//   createUserBuddy.open(
//     "POST",
//     "http://localhost:8005/wp-json/buddypress/v1/members"
//   );
//   createUserBuddy.setRequestHeader("Authorization", "Bearer " + token);
//   createUserBuddy.setRequestHeader(
//     "Content-Type",
//     "application/json;charset:UTF-8"
//   );
//   createUserBuddy.send(JSON.stringify(ourBuddyDAta));
//   createUserBuddy.onreadystatechange = function () {
//     if (createUserBuddy.readyState == 4) {
//       if (createUserBuddy.status == 201) {
//         console.log("buddypress account create");
//       }
//     }
//   };
// }
</script>

<style scoped>
.header {
  width: 100%;
  height: 100px;
  background-color: #0066cc;
  box-shadow: rgba(14, 30, 37, 0.12) 0px 2px 4px 0px,
    rgba(14, 30, 37, 0.32) 0px 2px 16px 0px;
}

.formulaire {
  width: 450px;
  margin: auto;
  padding: 20px;
  box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px, rgba(0, 0, 0, 0.24) 0px 1px 2px;
  height: 750px;
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

.form {
  display: grid;
}

input {
  width: 300px;
  height: 30px;
  border-radius: 5px;
  margin: auto;
  font-size: 18px;
}

.register_button {
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

.login_test {
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

.validation1 {
  height: 15px;
  position: relative;
  left: 350px;
  top: -25px;
  display: none;
}

.validation2 {
  height: 15px;
  position: relative;
  left: 350px;
  top: -25px;
  display: none;
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
