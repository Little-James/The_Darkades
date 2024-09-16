const galleryPhotos = document.querySelector(".galleryPhotos");
const galleryItems = galleryPhotos.querySelectorAll(".gallery-item");
const indicator = document.querySelector(".indicator");

const defaultItemFlex = "0 1 45px";
const hoverItemFlex = "1 1 309px";

const updateGalleryItems = () => {
	galleryItems.forEach((item) => {
		let flex = defaultItemFlex;

		if (item.isHovered) {
			flex = hoverItemFlex;
		}

		item.style.flex = flex;
	});
};

galleryItems[0].isHovered = true;
updateGalleryItems();

galleryItems.forEach((item) => {
	item.addEventListener("mouseenter", () => {
		galleryItems.forEach((otherItem) => {
			otherItem.isHovered = otherItem === item;
		})
		updateGalleryItems();
	});
});

galleryPhotos.addEventListener("mousemove", (e) => {
	indicator.style.left = `${e.clientX - galleryPhotos.getBoundingClientRect().left
		}px`;
});

