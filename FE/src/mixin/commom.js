import { errorSingle } from '@/utils/index'

export const formMixin = {
  data() {
    return {
      btnLoading: false
    }
  },
  computed: {
    errorForm: function() {
      return this.errors
    }
  },
  methods: {
    errorField(name) {
      return errorSingle(this.errorForm, name)
    }
  }
}

export const pagiMixin = {
  data() {
    return {
      list: [],
      total: 1,
      perPage: 1,
      currentPage: 1
    }
  },
  methods: {
    setPagi({ data, meta }) {
      const { per_page, total, current_page } = meta
      this.perPage = per_page
      this.total = total
      this.list = data
      this.currentPage = current_page
    },
    handleCurrentChange(page) {
      this.fetchData(page)
    }
  }
}

