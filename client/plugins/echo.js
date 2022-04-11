import Echo from 'laravel-echo'

window.Pusher = require('pusher-js')

export default (context, inject) => {
  const echo = new Echo({
    broadcaster: 'pusher',
    key: context.$config.WS_KEY, // .env
    wsHost: context.$config.WS_HOST,
    wsPort: context.$config.WS_PORT,
    forceTLS: context.$config.WS_FORCE_TLS,
    disableStats: true,
  })
  inject('echo', echo)
}
