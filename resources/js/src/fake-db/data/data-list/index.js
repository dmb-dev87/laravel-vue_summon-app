import mock from '@/fake-db/mock.js'

const data = {
  products: [
    {
      'id': 1,
      'group': 'office',
      'location': 'floor1',
      'status' : 'Activate',
      'email1': 'test1@outlook.com',
      'email2': 'test2@outlook.com',
      'name': 'Felecia Rower',
      'phonenumber1': '+1234567890',
      'phonenumber2': '+1234567890',
      'phonenumber3': '+1234567890',
      'role': 'Admin',
    },
    {
      'id': 2,
      'group': 'office',
      'location': 'floor2',
      'status' : 'Activate',
      'email1': 'test1@outlook.com',
      'email2': 'test2@outlook.com',
      'name': 'Beats HeadPhones',
      'phonenumber1': '+1234567890',
      'phonenumber2': '+1234567890',
      'phonenumber3': '+1234567890',
      'role': 'User',
    },
    {
      'id': 3,
      'group': 'office',
      'location': 'floor1',
      'status' : 'Activate',
      'email1': 'test1@outlook.com',
      'email2': 'test2@outlook.com',
      'name': 'Adalberto Granzin',
      'phonenumber1': '+1234567890',
      'phonenumber2': '+1234567890',
      'phonenumber3': '+1234567890',
      'role': 'Admin',
    },
    {
      'id': 4,
      'group': 'office',
      'location': 'floor3',
      'status' : 'Deactivate',
      'email1': 'test1@outlook.com',
      'email2': 'test2@outlook.com',
      'name': 'Altec Lansing',
      'phonenumber1': '+1234567890',
      'phonenumber2': '+1234567890',
      'phonenumber3': '+1234567890',
      'role': 'User',
    },
    {
      'id': 5,
      'group': 'office',
      'location': 'floor1',
      'status' : 'Deactivate',
      'email1': 'test1@outlook.com',
      'email2': 'test2@outlook.com',
      'name': 'Joaquina Weisenborn',
      'phonenumber1': '+1234567890',
      'phonenumber2': '+1234567890',
      'phonenumber3': '+1234567890',
      'role': 'Admin',
    },
    {
      'id': 6,
      'group': 'home',
      'status' : 'Deactivate',
      'location': 'floor1',
      'email1': 'test1@outlook.com',
      'email2': 'test2@outlook.com',
      'name': 'Verla Morgano',
      'phonenumber1': '+1234567890',
      'phonenumber2': '+1234567890',
      'phonenumber3': '+1234567890',
      'role': 'User',
    },
    {
      'id': 7,
      'group': 'home',
      'location': 'floor1',
      'email1': 'test1@outlook.com',
      'email2': 'test2@outlook.com',
      'status' : 'Activate',
      'name': 'Margot Henschke',
      'phonenumber1': '+1234567890',
      'phonenumber2': '+1234567890',
      'phonenumber3': '+1234567890',
      'role': 'User',
    },
    {
      'id': 8,
      'group': 'home',
      'location': 'floor1',
      'status' : 'Activate',
      'email1': 'test1@outlook.com',
      'email2': 'test2@outlook.com',
      'name': 'Sal Piggee',
      'phonenumber1': '+1234567890',
      'phonenumber2': '+1234567890',
      'phonenumber3': '+1234567890',
      'role': 'User',
    },
    {
      'id': 9,
      'group': 'home',
      'location': 'floor3',
      'status' : 'Activate',
      'email1': 'test1@outlook.com',
      'email2': 'test2@outlook.com',
      'name': 'Altec Lansing',
      'phonenumber1': '+1234567890',
      'phonenumber2': '+1234567890',
      'phonenumber3': '+1234567890',
      'role': 'User',
    },
  ], 
  groups: [
    {
      id: 1, 
      name: 'IT Department',
      included_contact: '1,2,3'      
    },
    {
      id: 2, 
      name: 'Sales Team',
      included_contact: '1,2,3'      
    },
    {
      id: 3, 
      name: 'Management Team',
      included_contact: '1,2,3'      
    },
    {
      id: 4, 
      name: 'Broadcast',
      included_contact: '1,2,3'      
    }
  ]
}


mock.onGet('/api/data-list/products').reply(() => {
  return [200, JSON.parse(JSON.stringify(data.products)).reverse()]
})

mock.onGet('/api/data-list/groups').reply(() => {
  return [200, JSON.parse(JSON.stringify(data.groups)).reverse()]
})

// POST : Add new Item
mock.onPost('/api/data-list/products/').reply((request) => {

  // Get event from post data
  const item = JSON.parse(request.data).item

  const length = data.products.length
  let lastIndex = 0
  if (length) {
    lastIndex = data.products[length - 1].id
  }
  item.id = lastIndex + 1

  data.products.push(item)

  return [201, {id: item.id}]
})

// POST : Add new Group
mock.onPost('/api/data-list/groups/').reply((request) => {

  // Get event from post data
  const item = JSON.parse(request.data).item

  const length = data.groups.length
  let lastIndex = 0
  if (length) {
    lastIndex = data.groups[length - 1].id
  }
  item.id = lastIndex + 1

  data.groups.push(item)

  return [201, {id: item.id}]
})


// Update Product
mock.onPost(/\/api\/data-list\/products\/\d+/).reply((request) => {

  const itemId = request.url.substring(request.url.lastIndexOf('/') + 1)

  const item = data.products.find((item) => item.id == itemId)
  Object.assign(item, JSON.parse(request.data).item)

  return [200, item]
})

// Update Group
mock.onPost(/\/api\/data-list\/groups\/\d+/).reply((request) => {

  const itemId = request.url.substring(request.url.lastIndexOf('/') + 1)

  const item = data.groups.find((item) => item.id == itemId)
  Object.assign(item, JSON.parse(request.data).item)

  return [200, item]
})


// DELETE: Remove Item
mock.onDelete(/\/api\/data-list\/products\/\d+/).reply((request) => {

  const itemId = request.url.substring(request.url.lastIndexOf('/') + 1)

  const itemIndex = data.products.findIndex((p) => p.id == itemId)
  data.products.splice(itemIndex, 1)
  return [200]
})

// DELETE: Remove Item Group
mock.onDelete(/\/api\/data-list\/groups\/\d+/).reply((request) => {

  const itemId = request.url.substring(request.url.lastIndexOf('/') + 1)

  const itemIndex = data.groups.findIndex((p) => p.id == itemId)
  data.groups.splice(itemIndex, 1)
  return [200]
})
