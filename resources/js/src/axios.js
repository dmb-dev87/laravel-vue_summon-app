// axios
import axios from 'axios'

// const baseURL = 'http://18.198.57.197'
const baseURL = 'http://localhost:8000'

export default axios.create({
  baseURL
  // You can add your headers here
})
