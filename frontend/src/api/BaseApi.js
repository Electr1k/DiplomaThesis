import axios from 'axios'
import {$api} from "@/api/index";

class BaseApi {
  constructor (data = {}) {
    this.apiUrl = 'http://localhost:8080/api/v1'
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

  async checkStatusResponse(error){
    switch (error.response.status) {
      case 401:
        await this.refreshToken()
        break
      case 403:
        throw new Error('У вас недостаточно прав')
      default:
        throw new Error(error.response.data.message ?? 'Произошла ошибка')
    }
  }

  async index(search = null) {
    try {
      return await axios.get(this.url.index(), {...this.getConfig(), params: search ? {search: search} : search})
    } catch (e) {
      await this.checkStatusResponse(e)
    }
  }

  async get(id) {
    try {
      return axios.get(this.url.show(id), this.getConfig())
    } catch (e) {
      await this.checkStatusResponse(e)
    }
  }

  async store(data, headers) {
    try {
      const config = this.getConfig()
      if (headers) config.headers = {...config.headers, ...headers}

      return await axios.post(this.url.store(), data, config)
    } catch (e) {
      await this.checkStatusResponse(e)
    }
  }

  async update(id, data, headers) {
    try {
      const config = this.getConfig()
      if (headers) config.headers = {...config.headers, ...headers}

      return await axios.put(this.url.update(id), data, config)
    } catch (e) {
      await this.checkStatusResponse(e)
    }
  }

  async delete(id) {
    try {
      return await axios.delete(this.url.delete(id), this.getConfig())
    } catch (e) {
      await this.checkStatusResponse(e)
    }
  }

  async refreshToken () {
    try {
      const token = await $api.auth.refresh()
      console.log(`new token ${token.data.access_token}`)
      localStorage.setItem('auth_token', token.data.access_token);
    }
    catch (e) {
      console.log('Ошибка рефреша токена ' + e.message)
      localStorage.removeItem('auth_token')
    }
  }

}

export default BaseApi
