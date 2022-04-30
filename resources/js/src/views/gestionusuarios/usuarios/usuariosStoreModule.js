import axios from '@axios'

export default {
  namespaced: true,
  state: {
   
  },
  getters: {},
  mutations: {},
  actions: {
    fetchUsers(ctx, queryParams) {
      return new Promise((resolve, reject) => {

        axios
          .get('/api/users', { params: queryParams })
          .then(response => {
              resolve(response)
            })
          .catch(error => reject(error))
      })
    },
 
    addUser(ctx, userData) {


      return new Promise((resolve, reject) => {
        axios
          .post('api/adduser',  userData, {
          
          })
          .then(response => resolve(response))
          .catch(error => reject(error))
      })
    },
    deleteUser(ctx, { id }) {
        return new Promise((resolve, reject) => {
          axios
            .delete(`api/deleteuser/${id}`)
            .then(response => resolve(response))
            .catch(error => reject(error))
        })
      },

      fetchroles(ctx) {
        return new Promise((resolve, reject) => {
  
          axios
            .get('/api/roles')
            .then(response => {
                resolve(response)
              })
            .catch(error => reject(error))
        })
      },
  },
}
