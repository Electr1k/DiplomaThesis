import axios from 'axios'
import {$api} from "@/api/index";

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

  getConfig() {
    const token = localStorage.getItem('auth_token')
    return {
      headers: token ? { Authorization: `Bearer ${token}` } : undefined
    }
  }

  async index(search = null) {
    try {
      return axios.get(this.url.index(), {...this.getConfig(), params: search ? {search: search} : search})
    } catch (e) {
      if (e.response.status === 401) await this.refreshToken()
      else throw e
    }
  }

  async get(id) {
    try {
      return axios.get(this.url.show(id), this.getConfig())
    } catch (e) {
      if (e.response.status === 401) await this.refreshToken()
      else throw e
    }
  }

  async store(data) {
    try {
      return await axios.post(this.url.store(), data, this.getConfig())
    } catch (e) {
      if (e.response.status === 401) await this.refreshToken()
    else
      throw e
    }
  }

  async update(id, data) {
    try {
      return await axios.put(this.url.update(id), data, this.getConfig())
    } catch (e) {
      if (e.response.status === 401) await this.refreshToken()
      else throw e
    }
  }

  async delete(id) {
    try {
      return await axios.delete(this.url.delete(id), this.getConfig())
    } catch (e) {
      if (e.response.status === 401) await this.refreshToken()
      else throw e
    }
  }

  async refreshToken () {
    const token = await $api.auth.refresh()
    console.log(`new token ${token.data.authorisation.token}`)

    localStorage.setItem('auth_token', token.data.authorisation.token);
  }

}

export default BaseApi
