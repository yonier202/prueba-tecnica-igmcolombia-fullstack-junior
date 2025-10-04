import api from "../../../lib/axios";

export default {
  list() {
    return api.get("/roles");
  },
};
