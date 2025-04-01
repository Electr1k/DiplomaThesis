import PermissionApi from "./PermissionApi";
import RoleApi from "@/api/RoleApi";

export const $api = {
  permissions: new PermissionApi(),
  roles: new RoleApi(),
}
