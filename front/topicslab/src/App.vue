<template>
  <div class="wrapper">
    <div id="nav">
      <router-link to="/">ホーム</router-link> |
      <template v-if="authenticated">
        <router-link to="/mypage">マイページ</router-link>
      </template>
      <template v-else>
        <router-link to="/login">ログイン</router-link>
      </template>
    </div>
    <div class="content">
      <router-view/>
    </div>
    <div class="copyright">
      <p>&copy; members.co</p>
    </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      authenticated: false
    }
  },
  watch: {
    $route () {
      this.authenticated = localStorage.getItem('authenticated') === 'true'
    }
  }
}
</script>

<style lang="scss">
html, body {
  height: 100%;
  min-height: 100%;
  overflow-x: hidden;
}

body {
  margin: 0;
  background: linear-gradient(-135deg, #E4A972, #9941D8);
  background-attachment: fixed;
}

#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;

  .content {
    max-width: 600px;
    width: 100%;
    margin: 0 auto;
    padding: 0 20px;
    padding-bottom: 20px;
  }
}

#nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: purple !important;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
.copyright {
  text-align: center;
  background-color: black;
  color: white;
  bottom: 0;
  left: 0;
  right: 0;
  position: absolute;
  font-size: 0.12rem;
}
</style>
