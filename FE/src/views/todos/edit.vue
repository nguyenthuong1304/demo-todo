<template>
  <div class="app-container">
    <el-form ref="form" :model="form" label-width="120px">
      <el-form-item label="Title" prop="title" :error="errorField('title')">
        <el-input v-model="form.title" />
      </el-form-item>
      <el-form-item label="Description">
        <el-input v-model="form.description" type="textarea" prop="description" :error="errorField('description')" />
      </el-form-item>
      <el-form-item label="Activity date" :error="errorField('start_date') || errorField('due_date')">
        <el-col :span="11">
          <el-date-picker v-model="form.start_date" type="date" placeholder="Pick start date" style="width: 100%;" />
        </el-col>
        <el-col :span="2" class="line">-</el-col>
        <el-col :span="11">
          <el-date-picker v-model="form.due_date" type="date" placeholder="Pick due date" style="width: 100%;" />
        </el-col>
      </el-form-item>
      <el-form-item label="Assignee" prop="user_id" :error="errorField('user_id')">
        <el-select v-model="form.user_id" placeholder="Please select assignee" style="width: 80%;">
          <el-option v-for="(user, key) in users" :key="key" :label="`${user.name} - ${user.email}`" :value="user.id" />
        </el-select>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit">Update</el-button>
        <el-button @click="onCancel">Cancel</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { getAssignees } from '@/api/user'
import * as todoApi from '@/api/todo'
import { formMixin } from '@/mixin/commom'
import { loading } from '@/utils/index'

export default {
  mixins: [formMixin],
  data() {
    return {
      form: {
        title: '',
        description: '',
        start_date: null,
        due_date: null,
        delivery: false,
        user_id: null
      },
      users: [],
      errors: {}
    }
  },
  async mounted() {
    const id = this.$route.params.id
    // eslint-disable-next-line
    const [_, { data }] = await Promise.all([this.fetchTodo(id), await getAssignees()])

    this.users = data
  },
  methods: {
    async fetchTodo(id) {
      const { data } = await todoApi.show(id)
      this.form = { ...data }
    },
    async onSubmit() {
      const load = loading()

      try {
        const { message } = await todoApi.update(this.$route.params.id, { ...this.form })
        this.$message({
          type: 'success',
          message
        })
        this.$router.push({ name: 'todo_index' })
      } catch (error) {
        if (error.response && error.response.status === 422) {
          const { data } = error.response
          this.errors = data.data
        }
      } finally {
        load.close()
      }
    },
    onCancel() {
      this.$message({
        message: 'cancel!',
        type: 'warning'
      })
    }
  }
}
</script>

<style scoped>
.line{
  text-align: center;
}
</style>

