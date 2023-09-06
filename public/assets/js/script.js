const modal  = document.querySelector('.modal-container');

window.addEventListener('click', clickOutside)

function openModal() {
  modal.classList.add('active')
}

function closeModal() {
  const descriptionInput = document.getElementById('description').value = ''
  const valueInput = document.getElementById('value').value = ''
  const date = document.getElementById('date').value = ''
  const category = document.getElementById('category').value = ''
  const bntForm = document.getElementById('btn-form').innerText = 'Registrar'
  const titleForm = document.getElementById('title-form').innerText = ''

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

  const descriptionInput = document.getElementById('description').value = json.description
  const valueInput = document.getElementById('value').value = json.value
  const date = document.getElementById('date').value = json.date
  const category = document.getElementById('category').value = json.category
  const bntForm = document.getElementById('btn-form').innerText = 'Salvar'
  const titleForm = document.getElementById('title-form').innerText = 'Edição de Registro'
  const form = document.querySelector('.form-modal').action = `finance/edit/${id}`

  openModal();
}
