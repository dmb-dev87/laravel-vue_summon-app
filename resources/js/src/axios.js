// axios
import axios from 'axios'

let baseURL;

if (window.location.hostname !== 'localhost') {
  baseURL = 'http://18.198.57.197'
}
else {
  baseURL = 'http://localhost:8000'
}

export default axios.create({
  baseURL
})
