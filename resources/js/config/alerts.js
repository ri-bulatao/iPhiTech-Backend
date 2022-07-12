import Swal from 'sweetalert2'

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

/**
 * Alert for successful operations
 * 
 * @param {String} title 
 * @param {String} text 
 */
export const AlertSuccess = (title = 'Success', text = 'Success Message') => {
    Swal.fire({
        icon: 'success',
        title: title,
        text: text
    })
}

export const AlertQuestion = (title = 'Question', text = 'Question description', showCancelButton, confirmButtonText) => {
    return new Promise((resolve, reject) => {
        Swal.fire({
            icon: 'question',
            title: title,
            text: text,
            showCancelButton: showCancelButton,
            confirmButtonText: confirmButtonText
        })
        .then(result => {
            if(result.isConfirmed) {
                resolve(result)
            }
            reject(result)
        })
    })
}

/**
 * Alert for failed operations
 * 
 * @param {String} title 
 * @param {String} text 
 */
export const AlertError = (title = 'Ooops', text = 'Something went wrong') => {
    Swal.fire({
        icon: 'error',
        title: title,
        text: text
    })
}

/**
 * Toast message for success message
 * 
 * @param {String} title 
 * @param {String} text 
 */
export const ToastSuccess = (title = 'Success', text = 'Success Message') => {
    Toast.fire({
        icon: 'success',
        title: title,
        text: text
    })
}

/**
 * Toast message for error exception
 * 
 * @param {String} title 
 * @param {String} text 
 */
export const ToastError = (title = 'Ooops', text = 'Something went wrong!') => {
    Toast.fire({
        icon: 'error',
        title: title,
        text: text
    })
}

