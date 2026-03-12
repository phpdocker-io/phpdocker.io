'use strict'

class PHPDockerMultiSelect {
    constructor (selectEl) {
        this._select      = selectEl
        this._options     = Array.from(selectEl.options)
        this._wrapper     = null
        this._button      = null
        this._dropdown    = null
        this._filterInput = null
        this._list        = null
        this._isOpen      = false

        selectEl.style.display = 'none'
        this._build()
        this._updateLabel()

        document.addEventListener('click', (e) => {
            if (!this._wrapper.contains(e.target)) {
                this.close()
            }
        })
    }

    _build () {
        const wrapper = document.createElement('div')
        wrapper.className = 'ms-wrapper relative'

        const button = document.createElement('button')
        button.type      = 'button'
        button.className = 'form-input text-left cursor-pointer overflow-hidden text-ellipsis whitespace-nowrap'
        button.innerHTML = '<span class="ms-label"></span>'
        button.addEventListener('click', (e) => {
            e.preventDefault()
            this._isOpen ? this.close() : this.open()
        })

        const dropdown = document.createElement('div')
        dropdown.className = 'absolute top-full w-full mt-1 z-10 bg-[#080d19] border border-[#1c3050] rounded-md hidden'

        const filterInput = document.createElement('input')
        filterInput.type        = 'text'
        filterInput.placeholder = 'Filter…'
        filterInput.className   = 'w-full text-[#e2e8f0] text-sm outline-none'
        filterInput.style.cssText = 'background:#0d1628; border:1px solid #1c3050; border-radius:0.375rem; padding:0.5rem 0.75rem; margin:0.5rem; width:calc(100% - 1rem); box-sizing:border-box;'
        filterInput.addEventListener('input', () => this._render(filterInput.value))

        const list = document.createElement('ul')
        list.className = 'list-none m-0'
        list.style.cssText = 'height:12rem; overflow-y:auto; padding:0.5rem;'

        dropdown.appendChild(filterInput)
        dropdown.appendChild(list)
        wrapper.appendChild(button)
        wrapper.appendChild(dropdown)

        this._select.insertAdjacentElement('afterend', wrapper)

        this._wrapper     = wrapper
        this._button      = button
        this._dropdown    = dropdown
        this._filterInput = filterInput
        this._list        = list

        this._render('')
    }

    _render (filter) {
        const lowerFilter = filter.toLowerCase()
        this._list.innerHTML = ''

        this._options.forEach((option) => {
            if (lowerFilter && !option.text.toLowerCase().includes(lowerFilter)) {
                return
            }

            const li    = document.createElement('li')
            const label = document.createElement('label')
            label.className = 'flex items-center gap-3 px-3 cursor-pointer text-sm text-[#e2e8f0] hover:bg-[#1c3050] hover:text-[#38bdf8]'
            label.style.cssText = 'padding-top:0.375rem; padding-bottom:0.375rem;'

            const checkbox    = document.createElement('input')
            checkbox.type     = 'checkbox'
            checkbox.value    = option.value
            checkbox.checked  = option.selected
            // no class — CSS rule `#generator input[type=checkbox]:not(.ms-check)` applies the toggle style

            checkbox.addEventListener('change', () => {
                option.selected = checkbox.checked
                this._updateLabel()
                this._select.dispatchEvent(new Event('change', { bubbles: true }))
            })

            label.appendChild(checkbox)
            label.appendChild(document.createTextNode(option.text))
            li.appendChild(label)
            this._list.appendChild(li)
        })
    }

    _updateLabel () {
        const selected = this._options.filter(o => o.selected).map(o => o.text)
        const labelEl  = this._button.querySelector('.ms-label')
        labelEl.textContent = selected.length > 0 ? selected.join(', ') : 'None selected'
    }

    selectByText (text) {
        const lower = text.toLowerCase()
        this._options.forEach(option => {
            if (option.text.toLowerCase() === lower) {
                option.selected = true
            }
        })
        this._render(this._filterInput.value)
        this._updateLabel()
    }

    open () {
        this._dropdown.classList.remove('hidden')
        this._filterInput.focus()
        this._isOpen = true
    }

    close () {
        this._dropdown.classList.add('hidden')
        this._isOpen = false
    }

    setOptions (names) {
        // Rebuild native <select> options
        this._select.innerHTML = ''
        names.forEach(name => {
            const opt   = document.createElement('option')
            opt.value   = name
            opt.text    = name
            this._select.appendChild(opt)
        })
        // Sync internal state and re-render
        this._options = Array.from(this._select.options)
        this._render(this._filterInput.value)
        this._updateLabel()
    }
}
