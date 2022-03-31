export function importAll(r) {
  let images = {};
  r.keys().map((item) => {
    images[item.replace("./", "")] = r(item);
  });
  return images;
}

export const settings = {
  dots: { className: "mainCarouselDots" },
  infinite: true,
  speed: 500,
  autoplay: true,
  autoplaySpeed: 5000,
  slidesToShow: 4,
  slidesToScroll: 4,
  arrows: true,
  draggable: true,
  variableWidth: true,
  initialSlide: 0,
  responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
        infinite: true,
        dots: false,
      },
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        dots: false,
        slidesToScroll: 2,
        arrows: false,
        centerMode: true,
        initialSlide: 2,
      },
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        dots: false,
        centerMode: true,
        arrows: false,
        slidesToScroll: 1,
      },
    },
  ],
};