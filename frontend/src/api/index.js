import PermissionApi from "./PermissionApi";
import RoleApi from "@/api/RoleApi";
import UserApi from "@/api/UserApi";
import CourierApi from "@/api/CourierApi";
import InactiveCourierApi from "@/api/InactiveCourierApi";
import CabinetApi from "@/api/CabinetApi";
import RegistrationCourierApi from "@/api/RegistrationCourierApi";
import SummaryReportApi from "@/api/SummaryReportApi";

export const $api = {
  permissions: new PermissionApi(),
  roles: new RoleApi(),
  users: new UserApi(),
  couriers: new CourierApi(),
  inactive_couriers: new InactiveCourierApi(),
  cabinets: new CabinetApi(),
  registrations: new RegistrationCourierApi(),
  summaryReport: new SummaryReportApi(),
}
