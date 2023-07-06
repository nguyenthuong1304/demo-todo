import request from '@/utils/request'

export function getList(params) {
  return request({
    url: `/todos`,
    method: 'get',
    params
  })
}

export function store(data) {
  return request({
    url: '/todos',
    method: 'post',
    data
  })
}

export function update(id, data) {
  return request({
    url: `/todos/${id}`,
    method: 'put',
    data
  })
}

export function show(id) {
  return request({
    url: `/todos/${id}`,
    method: 'get'
  })
}

export function remove(id) {
  return request({
    url: `/todos/${id}`,
    method: 'delete'
  })
}

export function changeStatus(data) {
  return request({
    url: `/todos/change-status`,
    method: 'post',
    data
  })
}

export function assignUser(data) {
  return request({
    url: `/todos/assign-user`,
    method: 'post',
    data
  })
}
