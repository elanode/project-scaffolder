export default {
  // Target: https://go.nuxtjs.dev/config-target
  target: 'static',

  publicRuntimeConfig: {
    OAUTH_REDIRECT_URI: process.env.OAUTH_REDIRECT_URI,
    OAUTH_CLIENT_ID: process.env.OAUTH_CLIENT_ID,
    BROWSER_URL: process.env.BROWSER_URL,
    BACKEND_URL: process.env.BACKEND_URL,
    BASE_URL: process.env.BASE_URL,
    WS_HOST: process.env.WS_HOST,
    WS_PORT: process.env.WS_PORT,
    WS_KEY: process.env.WS_KEY,
    WS_FORCE_TLS: process.env.WS_FORCE_TLS,
  },

  privateRuntimeConfig: {
    axios: {
      baseURL: process.env.BASE_URL,
    },
  },

  // Global page headers: https://go.nuxtjs.dev/config-head
  head: {
    title: 'client',
    htmlAttrs: {
      lang: 'en',
    },
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      { name: 'format-detection', content: 'telephone=no' },
    ],
    link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }],
  },

  // Global CSS: https://go.nuxtjs.dev/config-css
  css: [],

  // Plugins to run before rendering page: https://go.nuxtjs.dev/config-plugins
  plugins: [{ src: './plugins/echo', mode: 'client' }],

  // Auto import components: https://go.nuxtjs.dev/config-components
  components: true,

  // Modules for dev and build (recommended): https://go.nuxtjs.dev/config-modules
  buildModules: [
    // https://go.nuxtjs.dev/eslint
    '@nuxtjs/eslint-module',
  ],

  // Modules: https://go.nuxtjs.dev/config-modules
  modules: [
    // https://go.nuxtjs.dev/axios
    '@nuxtjs/axios',
  ],

  // Axios module configuration: https://go.nuxtjs.dev/config-axios
  axios: {
    // Workaround to avoid enforcing hard-coded localhost:3000: https://github.com/nuxt-community/axios-module/issues/308
    baseURL: process.env.BACKEND_URL,
    credentials: true,
  },

  // Build Configuration: https://go.nuxtjs.dev/config-build
  build: {},
}
