import BaseApi from './BaseApi'
import axios from "axios";

class DashBoardApi extends BaseApi {
  constructor () {
    super({ name: 'report/dashboard' })
    this.url.orders = () => `${this.apiUrl}/reports/dashboard/orders`
    this.url.newClients = () => `${this.apiUrl}/reports/dashboard/new-clients`
  }

  async orders() {
    try {
      return await axios.get(this.url.orders(), this.getConfig())
    } catch (e) {
      await this.checkStatusResponse(e)
    }
  }

  async newClients() {
    try {
      return await axios.get(this.url.newClients(), this.getConfig())
    } catch (e) {
      await this.checkStatusResponse(e)
    }
  }
}

export default DashBoardApi
