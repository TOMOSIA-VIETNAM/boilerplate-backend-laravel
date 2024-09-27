document.addEventListener("alpine:init", () => {
    Alpine.data('imageHandler', () => ({
        imageSrc: null,
        preview() {
            let file = this.$refs.imageInstance.files[0];
            if(!file || file.type.indexOf('image/') === -1) return;

            this.imageSrc = null;
            let reader = new FileReader();
            reader.onload = e => {
                this.imageSrc = e.target.result;
            }
            reader.readAsDataURL(file);
        },
    }));
});
