export default function ({ $axios }) {
    $axios.onRequest(config => {
        // Just have to know if Im actually calling the api
        console.log('Making request to ' + config.url)
    })
        // error grrrr
    $axios.onError(responseError => {
        const code = parseInt(responseError.response && responseError.response.status)
        console.error(code);
    })
}