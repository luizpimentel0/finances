const modal  = document.querySelector('.modal-container');

window.addEventListener('click', clickOutside)

function openModal() {
  modal.classList.add('active')
}

function closeModal() {
  const descriptionInput = document.getElementById('description')
  const valueInput = document.getElementById('value')
  const dateInput = document.getElementById('date')
  const categoryInput = document.getElementById('category')
  const btnForm = document.getElementById('btn-form')
  const titleForm = document.getElementById('title-form')
  const form = document.querySelector('.form-modal')
  form.action = '/finance/register'

  descriptionInput.value = ''
  valueInput.value = ''
  dateInput.value = ''
  categoryInput.value = ''
  btnForm.innerText = 'Register'
  titleForm.innerText = ''
  modal.classList.remove('active')
}

function clickOutside(event) {
  if (event.target == event.currentTarget) {
    closeModal();
  }
}

function closeNotification() {
  const notification = document.querySelector('.notification')

  notification.style.display = 'none';
}

async function handleEdit(id) {

  const response = await fetch(`/finance/show/${id}`)
  const json = await response.json();

  const { description, value, date, category } = json

  const descriptionInput = document.getElementById('description')
  const valueInput = document.getElementById('value')
  const dateInput = document.getElementById('date')
  const categoryInput = document.getElementById('category')
  const btnForm = document.getElementById('btn-form')
  const titleForm = document.getElementById('title-form')
  const form = document.querySelector('.form-modal')

  descriptionInput.value = description
  valueInput.value = value
  dateInput.value = date
  categoryInput.value = category
  btnForm.innerText = 'Salvar'
  titleForm.innerText = 'Edição de Registro'
  form.action = `finance/edit/${id}`
  modal.classList.remove('active')

  openModal();
}
