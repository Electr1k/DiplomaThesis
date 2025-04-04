import PermissionApi from "./PermissionApi";
import RoleApi from "@/api/RoleApi";
import UserApi from "@/api/UserApi";
import CourierApi from "@/api/CourierApi";
import CabinetApi from "@/api/CabinetApi";

export const $api = {
  permissions: new PermissionApi(),
  roles: new RoleApi(),
  users: new UserApi(),
  couriers: new CourierApi(),
  cabinets: new CabinetApi(),
}
