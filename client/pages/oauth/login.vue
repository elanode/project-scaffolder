<template>
  <div>
    <h1>Logging in...</h1>
    errors: {{ errors }}
    <br />
    code: {{ code }}
    <br />
    state: {{ state }}
    <br />
    localState: {{ localState }}
    <br />
    localVerifier: {{ localVerifier }}
  </div>
</template>

<script>
export default {
  name: 'OauthSuccessPage',
  data() {
    return {
      errors: null,
      code: null,
      state: null,
      localState: null,
      localVerifier: null,
    }
  },
  mounted() {
    const urlParams = new URLSearchParams(window.location.search)
    const code = urlParams.get('code')
    const state = urlParams.get('state')
    this.code = code
    this.state = state
    this.localState = window.localStorage.getItem('state')
    this.localVerifier = window.localStorage.getItem('verifier')
    if (code && state) {
      if (state === window.localStorage.getItem('state')) {
        const params = {
          grant_type: 'authorization_code',
          client_id: `${this.$config.OAUTH_CLIENT_ID}`,
          redirect_uri: `${this.$config.OAUTH_REDIRECT_URI}`,
          code_verifier: window.localStorage.getItem('verifier'),
          code,
        }

        this.$axios
          .$post(`${this.$config.BACKEND_URL}/oauth/token`, params)
          .then((resp) => {
            window.opener.postMessage(resp)
            localStorage.removeItem('state')
            localStorage.removeItem('verifier')
            window.close()
          })
          .catch((e) => {
            console.dir(e)
            this.errors = e
          })
      }
    }
  },
}
</script>
