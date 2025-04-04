import BaseApi from './BaseApi'

class UserApi extends BaseApi {
  constructor () {
    super({ name: 'users' })
  }
}

export default UserApi
