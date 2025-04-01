import PermissionApi from "./PermissionApi";
import RoleApi from "@/api/RoleApi";
import UserApi from "@/api/UserApi";

export const $api = {
  permissions: new PermissionApi(),
  roles: new RoleApi(),
  users: new UserApi(),
}
