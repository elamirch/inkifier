extern crate image;
extern crate imageproc;

use image::{DynamicImage, GrayImage};
use imageproc::edges::canny;
use std::env;
use std::path::Path;

fn main() {
    let args: Vec<String> = env::args().collect();
    if args.len() != 2 {
        panic!();
    }

    let image_path = Path::new(&args[1]);
    let img: DynamicImage = image::open(image_path).expect("Failed to open image");
    let gray_image: GrayImage = img.into_luma8();
    let sigma = 25.0;
    let edges = canny(&gray_image, sigma, 30.0);
    let output_path = Path::new("output.png");
    edges.save(output_path).expect("Failed to save image");
}
