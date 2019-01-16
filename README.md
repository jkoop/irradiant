# Irradiant
Irradiant is a "per-triangle" 3D render engine that outputs `.svg` files. It's made to be super fast.

The Utah Teapot as rendered by Irradiant v0.7.3:
![](screenshot.png)

## Notice
This was written for [Ubuntu](//ubuntu.com "Ubuntu's website's homepage")-compatible OSs such as [Ubuntu](//ubuntu.com "Ubuntu's website's homepage"), and [Linux Mint](//linuxmint.com "Linux Mint's website's homepage").

## Discriptions
### `animate.php`
Generates an animated GIF image and MP4 of the SVG inputted, starting with the background and one triangle for the first frame, then adding one triangle per frame

### `chess`, `cube`, `cylinder`, `teapot`, `triangle`, `triangle2`
Irradiant files

### `irradiant.php`
Irradiant

### `*.stl`
ASCII STL files

### `stl2irr.sh`
BASH script to convert ASCII STL files to Irradiant files

## Dependencies
### `animate.php`
- bash
- ffmpeg
- php7.2-cli

### `irradiant.php`
- php7.2-cli

### `stl2irr.sh`
- bash

## Usages
### `animate.php`
`./animate.php [SVG]`

### `irradiant.php`
Usage: `./irradiant.php [options] > [output.svg]`
Example: `./irradiant.php -i cube -z 1 > file.svg`

| Option | Discription |
| --- | --- |
| `-b` | background colour; default: `#FFF` |
| `-i` | irradiant compliant file for input |
| `-h` | height of output svg; default: `480` |
| `-w` | width of ouput svg;   default: `640` |
| `-v` | print version and exit |
| `-z` | zoom multipier; 1 = 90° view angle |
| | default: `1.8` 2 ≈ 40° |
| | 3 ≈ 26° |
| | 4 ≈ 20° |
| | sine( √2 / 2z ) --> degrees / 2 |
| `--help` | print this help and exit |
| `--wireframe` | render wireframe |

### `stl2irr.sh`
`./stl2irr.sh [ASCII STL] > [IRRADIANT]`
