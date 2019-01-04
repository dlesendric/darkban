import axios from 'axios'
import { API_URL } from "./../config/config"

export default axios.create({
  baseURL: API_URL
})