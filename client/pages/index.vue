<template>
  <div style="height: 100vh">
    <div class="test">
      <div>
        <button
          style="width: 200px; height: 150px; margin: auto"
          @click.prevent="openLoginWindow"
        >
          Login Click Me
        </button>
        <button
          style="width: 200px; height: 150px; margin: auto"
          @click.prevent="getUser()"
        >
          Get User
        </button>
        <button
          style="width: 200px; height: 150px; margin: auto"
          @click.prevent="refreshToken()"
        >
          Refresh Token
        </button>
        <button
          style="width: 200px; height: 150px; margin: auto"
          @click.prevent="setStateVerifier()"
        >
          Set State Verifier To Login again
        </button>
        <button
          style="width: 200px; height: 150px; margin: auto"
          @click.prevent="logout()"
        >
          Logout
        </button>
      </div>
    </div>
    <h1>user</h1>
    : {{ user }}
    <br />
    <h1>firstToken</h1>
    : {{ firstToken }}
    <br />
    <h1>refreshed</h1>
    : {{ refreshed }}
  </div>
</template>

<script>
import crypto from 'crypto-js'
// https://dev.to/stefant123/pkce-authenticaton-for-nuxt-spa-with-laravel-as-backend-170n
export default {
  name: 'IndexPage',
  data() {
    return {
      email: '',
      password: '',
      state: '',
      challenge: '',
      user: null,
      firstToken: null,
      refreshed: null,
    }
  },

  computed: {
    loginUrl() {
      return (
        `${this.$config.BACKEND_URL}/oauth/authorize` +
        `?client_id=${this.$config.OAUTH_CLIENT_ID}` +
        `&redirect_uri=${this.$config.OAUTH_REDIRECT_URI}` +
        `&response_type=code` +
        `&scope=*` +
        `&state=${this.state}` +
        `&code_challenge=${this.challenge}` +
        '&code_challenge_method=S256'
      )
    },
  },
  mounted() {
    window.addEventListener('message', (e) => {
      if (
        e.origin !== this.$config.BROWSER_URL ||
        !Object.keys(e.data).includes('access_token')
      ) {
        return
      }
      console.log(e.data)
      const { token_type, expires_in, access_token, refresh_token } = e.data
      this.firstToken = e.data
      this.$axios.setToken(access_token, token_type)

      this.getUser()
    })

    this.setStateVerifier()
  },

  methods: {
    openLoginWindow() {
      window.open(this.loginUrl, 'popup', 'width=700,height=700')
    },
    setStateVerifier() {
      this.state = this.createRandomString(40)
      const verifier = this.createRandomString(128)

      this.challenge = this.base64Url(crypto.SHA256(verifier))
      window.localStorage.setItem('state', this.state)
      window.localStorage.setItem('verifier', verifier)
    },
    createRandomString(num) {
      return [...Array(num)].map(() => Math.random().toString(36)[2]).join('')
    },

    base64Url(string) {
      return string
        .toString(crypto.enc.Base64)
        .replace(/\+/g, '-')
        .replace(/\//g, '_')
        .replace(/=/g, '')
    },

    getUser() {
      this.$axios
        .$get('/api/user')
        .then((resp) => {
          this.user = resp
        })
        .catch((e) => {
          this.user = 'not authenticated'
        })
    },

    logout() {
      this.$axios
        .$post('/api/logout')
        .then(() => (this.user = null))
        .catch((err) => console.log(err))
    },

    async refreshToken() {
      try {
        const res = await this.$axios.$post('/oauth/token', {
          grant_type: 'refresh_token',
          client_id: this.$config.OAUTH_CLIENT_ID,
        })
        const { token_type, expires_in, access_token, refresh_token } = res
        this.$axios.setToken(access_token, token_type)

        this.refreshed = res
      } catch (err) {
        this.refreshed = err.response.data
      }
    },
  },
}
</script>

<style lang="css">
.test {
  min-height: 50%;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: center;
}
</style>
