import axios from '@axios'

export default {
  namespaced: true,
  state: {
   
  },
  getters: {},
  mutations: {},
  actions: {
    fetchRoles(ctx, queryParams) {
      return new Promise((resolve, reject) => {

        axios
          .get('/api/roles', { params: queryParams })
          .then(response => {
              resolve(response)
            })
          .catch(error => reject(error))
      })
    },

    fetchPermissions(ctx, queryParams) {
      return new Promise((resolve, reject) => {

        axios
          .get('/api/permissions')
          .then(response => {
              resolve(response)
            })
          .catch(error => reject(error))
      })
    },
 
    addRole(ctx, userData) {
      return new Promise((resolve, reject) => {
        axios
          .post('api/addrole',  userData)
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    deleteRole(ctx, { id }) {
        return new Promise((resolve, reject) => {
          axios
            .delete(`api/deleterole/${id}`)
            .then(response => resolve(response))
            .catch(error => reject(error))
        })
      },
  },
}
