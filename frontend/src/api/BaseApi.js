import axios from 'axios'

class BaseApi {
  constructor (data = {}) {
    this.apiUrl = 'http://localhost/api/v1'
    this.name = data.name
    this.url = {
      index: () => `${this.apiUrl}/${data.name}`,
      show: (id) => `${this.apiUrl}/${data.name}/${id}`,
      store: () => `${this.apiUrl}/${data.name}`,
      update: (id) => `${this.apiUrl}/${data.name}/${id}`,
      delete: (id) => `${this.apiUrl}/${data.name}/${id}`,
    }
  }

  index (config = {}) {
    return axios.get(this.url.index(), config)
  }

  get (id) {
    return axios.get(this.url.show(id))
  }

  store (data) {
    return axios.post(this.url.store(), data)
  }

  update (id, data) {
    return axios.put(this.url.update(id), data)
  }

  delete (id) {
    return axios.delete(this.url.delete(id))
  }

}

export default BaseApi
