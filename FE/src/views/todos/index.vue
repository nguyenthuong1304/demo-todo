<template>
  <div class="app-container">
    <div style="margin-bottom: 5px">
      <el-row>
        <router-link :to="{ name: 'todo_create'}" tag="span">
          <el-button size="small" type="primary" icon="el-icon-edit">Create new todo</el-button>
        </router-link>
        <el-button
          :disabled="!multipleSelection.length"
          size="small"
          type="info"
          icon="el-icon-edit"
          style="margin-left: 5px;"
          @click="dialogFormVisible = true"
        >Assign to user</el-button>
        <el-button
          :disabled="!multipleSelection.length"
          size="small"
          type="warning"
          icon="el-icon-edit"
          style="margin-left: 5px;"
          @click="dialogFormStatusVisible = true"
        >Change status</el-button>
      </el-row>
    </div>

    <el-table
      ref="multipleTable"
      v-loading="listLoading"
      :data="list"
      element-loading-text="Loading"
      row-key="id"
      border
      fit
      highlight-current-row
      @selection-change="handleSelectionChange"
    >
      <el-table-column align="center" label="Title" width="95">
        <el-table-column type="selection" width="55" />
        <template slot-scope="scope">
          {{ scope.row.title }}
        </template>
      </el-table-column>
      <el-table-column label="Description">
        <template slot-scope="scope">
          {{ scope.row.description }}
        </template>
      </el-table-column>
      <el-table-column label="Start date">
        <template slot-scope="scope">
          {{ scope.row.start_date }}
        </template>
      </el-table-column>
      <el-table-column label="Due date">
        <template slot-scope="scope">
          {{ scope.row.due_date }}
        </template>
      </el-table-column>
      <el-table-column label="Assignee">
        <template slot-scope="scope">
          {{ scope.row.user ? scope.row.user.name : 'No Assignee' }}
        </template>
      </el-table-column>
      <el-table-column label="Status" align="center">
        <template slot-scope="scope">
          <el-button v-if="scope.row.status === 2" type="success" icon="el-icon-check" circle />
          <el-button v-if="scope.row.status === 1" type="warning" icon="el-icon-more" circle />
          <el-button v-if="scope.row.status === 0" type="primary" icon="el-icon-edit" circle />
        </template>
      </el-table-column>
      <el-table-column label="Thao tác" width="200" align="center">
        <template slot-scope="scope">
          <el-row>
            <router-link :to="{ name: 'todo_edit', params: { id: scope.row.id }}" tag="span">
              <el-button size="small" icon="el-icon-edit">Edit</el-button>
            </router-link>

            <el-button size="small" type="danger" @click="handleDelete(scope.row.id)">Delete</el-button>
          </el-row>
        </template>
      </el-table-column>
    </el-table>
    <div style="margin-top: 10px">
      <el-pagination
        background
        layout="prev, pager, next"
        :total="total"
        :page-size="perPage"
        @current-change="handleCurrentChange"
      />
    </div>
    <DialogAssign
      :dialog-form-visible="dialogFormVisible"
      :users="users"
      @closeModalAssign="dialogFormVisible=false"
      @submit="assignUser"
    />
    <DialogChangeStatus
      :dialog-form-visible="dialogFormStatusVisible"
      @closeModalAssign="dialogFormStatusVisible=false"
      @submit="changeStatusTodos"
    />
  </div>
</template>
<script>
import { pagiMixin } from '@/mixin/commom'
import { getList, remove, assignUser, changeStatus } from '@/api/todo'
import { getAssignees } from '@/api/user'
import DialogAssign from './dialog-assign.vue'
import DialogChangeStatus from './dialog-change-status.vue'

export default {
  components: { DialogAssign, DialogChangeStatus },
  mixins: [pagiMixin],
  data() {
    return {
      listLoading: true,
      labelPosition: 'top',
      multipleSelection: [],
      dialogFormVisible: false,
      dialogFormStatusVisible: false,
      users: []
    }
  },
  async mounted() {
    const [{ data }] = await Promise.all([getAssignees(), this.fetchData(1)])

    this.users = data
  },
  methods: {
    async fetchData(nextPage) {
      this.listLoading = true
      const response = await getList({ page: nextPage })
      this.setPagi(response)
      this.listLoading = false
    },
    edit(id) {
      this.$router.push({ name: 'todo_edit', params: { id }})
    },
    async handleDelete(id) {
      this.$confirm('Are you sure to delete?', 'confirm')
        .then(async(config) => {
          const { message } = await remove(id)
          this.$message({
            type: 'success',
            message
          })

          await this.fetchData(1)
        })
    },
    handleSelectionChange(val) {
      this.multipleSelection = val.map(i => i.id)
    },
    async assignUser(user_id) {
      if (user_id) {
        const { message } = await assignUser({ user_id, todo_ids: this.multipleSelection })
        this.$message({
          type: 'success',
          message
        })
        await this.fetchData(1)
      }

      this.dialogFormVisible = false
    },
    async changeStatusTodos(status) {
      const { message } = await changeStatus({ status, todo_ids: this.multipleSelection })
      this.$message({
        type: 'success',
        message
      })
      await this.fetchData(1)

      this.dialogFormStatusVisible = false
    }
  }
}
</script>
<style>
.el-form-item {
  width: 100%;
  padding: 0 5px;
}

.el-select {
  width: 100%;
}
</style>
