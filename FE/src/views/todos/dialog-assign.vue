<template>
  <el-dialog title="Change assignee" :visible.sync="dialogFormVisible">
    <el-form>
      <el-form-item label="Assignees" :label-width="formLabelWidth">
        <el-select v-model="user_id" placeholder="Please select assignee" style="width: 80%;">
          <el-option v-for="(user, key) in users" :key="key" :label="`${user.name} - ${user.email}`" :value="user.id" />
        </el-select>
      </el-form-item>
    </el-form>
    <span slot="footer" class="dialog-footer">
      <el-button @click="$emit('closeModalAssign')">Cancel</el-button>
      <el-button type="primary" @click="$emit('submit', user_id)">Confirm</el-button>
    </span>
  </el-dialog>
</template>

<script>
export default {
  props: {
    dialogFormVisible: {
      type: Boolean,
      default: false
    },
    users: {
      default: []
    }
  },
  data() {
    return {
      formLabelWidth: '120px',
      user_id: null
    }
  }
}
</script>
