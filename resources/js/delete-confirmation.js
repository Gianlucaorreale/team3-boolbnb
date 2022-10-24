const deleteForm = document.querySelectorAll(".delete-form");
console.log(deleteForm);
deleteForm.forEach(form=>{
  form.addEventListener('submit',(event)=>{
    event.preventDefault();
    const hasConfirmed = confirm('Sei sicuro di voler eliminare questo post??');
    console.log(hasConfirmed);
    console.log(form);
    if(hasConfirmed){form.submit()};
  })
})
