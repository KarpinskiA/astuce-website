import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

  static values = {
    addLabel: String,
    deleteLabel: String
  }

  /**
  * Dynamically injects “Add” and “Remove” buttons
  */
  connect() {
    this.index = this.element.childElementCount
    const btn = document.createElement('button')
    btn.setAttribute('class', 'btn btn-success')
    btn.innerText = this.addLabelValue || 'Ajouter un élément'
    btn.setAttribute('type', 'button')
    btn.addEventListener('click', this.addElement)
    this.element.childNodes.forEach(this.addDeleteButton)
    this.element.append(btn)
  }

  /**
   * Adds a new entry to the HTML structure
   * 
   * @param {MouseEvent} e
   */
  addElement = (e) => {
    e.preventDefault()
    const element = document.createRange().createContextualFragment(
      this.element.dataset['prototype'].replaceAll('__name__', this.index)
    ).firstElementChild
    this.addDeleteButton(element)
    this.index++
    e.currentTarget.insertAdjacentElement('beforebegin', element)
  }

  /**
   * Adds a button to delete a line
   * 
   * @param {HTMLElement} item
   */
  addDeleteButton = (item) => {
    const btn = document.createElement('button')
    btn.setAttribute('class', 'btn btn-danger')
    btn.innerText = this.deleteLabelValue || 'Supprimer'
    btn.setAttribute('type', 'button')
    item.append(btn)
    btn.addEventListener('click', e => {
      e.preventDefault()
      item.remove()
    })
  }
}