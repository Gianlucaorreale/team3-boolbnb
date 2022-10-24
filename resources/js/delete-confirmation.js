const deleteForm = document.querySelectorAll(".delete-form");
const deleteBtn = document.querySelectorAll(".delete");
const confirmDelete = document.querySelector(".discard");

deleteForm.forEach(form=>{
  form.addEventListener('submit',(event)=>{
    event.preventDefault();
    confirmDelete.addEventListener('click',(event)=>{
      form.submit();
    });
  })
})
