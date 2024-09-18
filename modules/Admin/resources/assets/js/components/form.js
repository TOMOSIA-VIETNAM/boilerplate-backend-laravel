document.addEventListener("alpine:init", () => {
    Alpine.data('submitForm', () => ({
        formData: { name: '', id: null },
        errorMsg: '',
        mode: 'create',

        submitForm() {
            const that = this;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const routeUrl = that.mode === 'edit'
                ? `${document.getElementById('permission-edit-route').value}/${that.formData.id}`
                : document.getElementById('permission-store-route').value;

            fetch(routeUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify(that.formData),
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 422) {
                        return response.json().then(errors => {
                            that.errorMsg = errors.errors.name[0]
                        });
                    }
                    throw new Error('Network response was not ok');
                }
                location.reload();
            })
            .catch(error => {
                that.errorMsg = 'An error occurred. Please try again.';
            });
        },

        setEditMode(permission) {
            this.mode = 'edit';
            this.formData.name = permission.name;
            this.formData.id = permission.id;
            this.errorMsg = '';
            $('#staticBackdrop').modal('show');
        },

        resetForm() {
            this.formData = { name: '', id: null };
            this.errorMsg = '';
            this.mode = 'create';
        }
    }));
});
