import axios from 'axios'

class BaseApi {
  constructor (data = {}) {
    this.apiUrl = 'http://localhost/api/v1'
    this.name = data.name
    const token = localStorage.getItem('auth_token')
    this.config = {
      headers: token ? { Authorization: `Bearer ${token}` } : undefined
    }

    this.url = {
      index: () => `${this.apiUrl}/${data.name}`,
      show: (id) => `${this.apiUrl}/${data.name}/${id}`,
      store: () => `${this.apiUrl}/${data.name}`,
      update: (id) => `${this.apiUrl}/${data.name}/${id}`,
      delete: (id) => `${this.apiUrl}/${data.name}/${id}`,
    }
  }

  index (search = null) {
    return axios.get(this.url.index(), { ...this.config, params: search ? {search: search} : search})
  }

  get (id) {
    return axios.get(this.url.show(id), this.config)
  }

  store (data) {
    return axios.post(this.url.store(), data, this.config)
  }

  update (id, data) {
    return axios.put(this.url.update(id), data, this.config)
  }

  delete (id) {
    return axios.delete(this.url.delete(id), this.config)
  }

}

export default BaseApi
