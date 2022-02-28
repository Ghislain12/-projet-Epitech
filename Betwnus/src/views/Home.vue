<template>
  <div class="container">
    <div class="loader">
      <span class="lettre">B</span>
      <span class="lettre">E</span>
      <span class="lettre">T</span>
      <span class="lettre">W</span>
      <span class="lettre">N</span>
      <span class="lettre">'</span>
      <span class="lettre">U</span>
      <span class="lettre">S</span>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    setTimeout(function () {
      window.location.href = window.location.origin + `/login`;
    }, 6000);
  },
};
</script>

<style scoped>
.container {
  background: #0066cc;
  width: 100%;
  height: 100vh;
}
.loader {
  position: absolute;
  width: 100%;
  height: 100%;
  background: #0066cc;
  display: flex;
  justify-content: center;
  align-items: center;
}

.lettre {
  color: white;
  font-size: 80px;
  letter-spacing: 15px;
  margin-bottom: 150px;
  animation: flash 1.5s infinite;
}

@keyframes flash {
  0% {
    color: aliceblue;
    text-shadow: 0 0 7px aliceblue;
  }
  90% {
    color: #0066cc;
    text-shadow: none;
  }
  100% {
    color: aliceblue;
    text-shadow: 0 0 7px aliceblue;
  }
}

.lettre:nth-child(1) {
  animation-delay: 0.1s;
}

.lettre:nth-child(2) {
  animation-delay: 0.2s;
}
.lettre:nth-child(3) {
  animation-delay: 0.3s;
}
.lettre:nth-child(4) {
  animation-delay: 0.4s;
}
.lettre:nth-child(5) {
  animation-delay: 0.5s;
}
.lettre:nth-child(6) {
  animation-delay: 0.6s;
}
.lettre:nth-child(7) {
  animation-delay: 0.7s;
}
.lettre:nth-child(8) {
  animation-delay: 0.8s;
}
</style>
