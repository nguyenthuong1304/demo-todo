<template>
  <el-dialog title="Change status" :visible.sync="dialogFormVisible">
    <el-form>
      <el-form-item label="Status" :label-width="formLabelWidth">
        <el-select v-model="status" placeholder="Please select assignee" style="width: 80%;">
          <el-option v-for="(sta, key) in statuses" :key="key" :label="sta.name" :value="sta.status" />
        </el-select>
      </el-form-item>
    </el-form>
    <span slot="footer" class="dialog-footer">
      <el-button @click="$emit('closeModalAssign')">Cancel</el-button>
      <el-button type="primary" @click="$emit('submit', status)">Confirm</el-button>
    </span>
  </el-dialog>
</template>

<script>
export default {
  props: {
    dialogFormVisible: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      formLabelWidth: '120px',
      status: 0,
      statuses: [
        { status: 0, name: 'Todo' },
        { status: 1, name: 'Inprogress' },
        { status: 2, name: 'Done' }
      ]
    }
  }
}
</script>
