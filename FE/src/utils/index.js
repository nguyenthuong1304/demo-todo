import { Loading } from 'element-ui'

export function errorSingle(errors, name) {
  if (errors === undefined) return ''

  return errors[name]
}

export function loading(options = undefined) {
  return Loading.service(options || {
    lock: true,
    text: 'Loading',
    spinner: 'el-icon-loading',
    background: 'rgba(0, 0, 0, 0.7)'
  })
}
