<template>
  <h1>Logging in...</h1>
</template>

<script>
export default {
  name: 'OauthSuccessPage',
  mounted() {
    const urlParams = new URLSearchParams(window.location.search)
    const code = urlParams.get('code')
    const state = urlParams.get('state')

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
          })
      }
    }
  },
}
</script>
