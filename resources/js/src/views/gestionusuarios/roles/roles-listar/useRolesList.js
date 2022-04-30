import { ref, watch, computed } from '@vue/composition-api'
import store from '@/store'
import { title } from '@core/utils/filter'

// Notification
import { useToast } from 'vue-toastification/composition'
import ToastificationContent from '@core/components/toastification/ToastificationContent.vue'

export default function useRolesList() {
  // Use toast
  const toast = useToast()

  const refUserListTable = ref(null)

  // Table Handlers
  const tableColumns = [
    { key: 'id', sortable: true},
    { key: 'title', sortable: true, label: 'Role' },

    { key: 'actions' },
  ]
  const perPage = ref(10)
  const totalUsers = ref(0)
  const currentPage = ref(1)
  const perPageOptions = [10, 25, 50, 100]
  const searchQuery = ref('')
  const sortBy = ref('id')
  const isSortDirDesc = ref(true)


  const dataMeta = computed(() => {
    const localItemsCount = refUserListTable.value ? refUserListTable.value.localItems.length : 0
    return {
      from: perPage.value * (currentPage.value - 1) + (localItemsCount ? 1 : 0),
      to: perPage.value * (currentPage.value - 1) + localItemsCount,
      of: totalUsers.value,
    }
  })

  const refetchData = () => {
    refUserListTable.value.refresh()
  }

  watch([currentPage, perPage, searchQuery], () => {
    refetchData()
  })

  const fetchDeleteUser = id => {
    store.dispatch('app-user/deleteRole', {
      id,
    }).then(response => {
      if (response.data.status) {
        toast({
          component: ToastificationContent,
          props: {
            title: 'Role Eliminado',
            icon: 'CheckIcon',
            variant: 'success',
          },
        })
        refetchData()
      }
    }).catch(() => {
      toast({
        component: ToastificationContent,
        props: {
          title: 'Error al eliminar Role',
          icon: 'AlertTriangleIcon',
          variant: 'danger',
        },
      })
    })
  }

  const fetchUsers = (ctx, callback) => {
    store
      .dispatch('app-user/fetchRoles', {
        q: searchQuery.value,
        perPage: perPage.value,
        page: currentPage.value,
        sortBy: sortBy.value,
        sortDesc: isSortDirDesc.value,

      })
      .then(response => {

        const { users, total } = response.data
        callback(users)
        totalUsers.value = total


      })
      .catch(() => {
        toast({
          component: ToastificationContent,
          props: {
            title: 'No existen Roles',
            icon: 'AlertTriangleIcon',
            variant: 'danger',
          },
        })
      })
  }



  return {
    fetchUsers,
    fetchDeleteUser,
    tableColumns,
    perPage,
    currentPage,
    totalUsers,
    dataMeta,
    perPageOptions,
    searchQuery,
    sortBy,
    isSortDirDesc,
    refUserListTable,


    refetchData,


  }
}
