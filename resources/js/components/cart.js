export default function addToCartForm() {
    return {
        loading: false,

        submit(event) {
            this.loading = true;
            const form = event.target;
            const formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: formData,
            })
                .then((response) => {
                    if (!response.ok) throw response;
                    return response.json();
                })
                .then((data) => {
                    // Update Navbar
                    window.dispatchEvent(
                        new CustomEvent("cart-updated", {
                            detail: { count: data.cartCount },
                        })
                    );

                    // Optional: Replace alert with a nice toast later
                    // alert(data.message);
                })
                .catch(async (error) => {
                    console.error("Error:", error);
                    // Handle validation errors if sent as JSON
                    if (error.json) {
                        const errData = await error.json();
                        alert(errData.message || "Something went wrong");
                    }
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    };
}
