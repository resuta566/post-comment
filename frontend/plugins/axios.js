export default function ({ $axios }) {
    $axios.onRequest(config => {
        console.log('Making request to ' + config.url)
    })

    $axios.onError(responseError => {
        const code = parseInt(responseError.response && responseError.response.status)
        console.error(code);
    })
}