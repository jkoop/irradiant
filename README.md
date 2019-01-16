# ReadMe for Vector3D v0.7.3.1
## Notice
This was written for [Ubuntu](//ubuntu.com "Ubuntu's website's homepage")-compatible OSs such as [Ubuntu](//ubuntu.com "Ubuntu's website's homepage"), and [Linux Mint](//linuxmint.com "Linux Mint's website's homepage").

## Files
### Directory Listing
```
total 4268
-rwxr-xr-x 1 joek joek     562 Nov 13 19:52 animate.php
-rw-r--r-- 1 joek joek   90779 Nov 13 19:52 chess
-rw-rw-r-- 1 joek joek  155970 Nov 13 19:52 chess.stl
-rw-rw-r-- 1 joek joek     459 Nov 13 19:52 cube
-rw-r--r-- 1 joek joek    4895 Nov 13 19:52 cylinder
-rw-rw-r-- 1 joek joek   11427 Nov 13 19:52 cylinder.stl
-rw-r--r-- 1 joek joek 1476642 Nov 13 20:57 file.svg
-rw-r--r-- 1 joek joek    2434 Jan  2 17:18 README.md
-r-xr--r-- 1 joek joek     550 Nov 13 19:52 stl2v3d.sh
-rw-r--r-- 1 joek joek  939539 Nov 13 19:52 teapot
-rw-rw-r-- 1 joek joek 1642517 Nov 13 19:52 teapot.stl
-rw-r--r-- 1 joek joek      43 Nov 13 19:52 triangle
-rw-r--r-- 1 joek joek      38 Nov 13 20:34 triangle2
-rwxrwxr-x 1 joek joek    5497 Nov 13 21:02 vector3d.php
```

### animate.php
Generates an animated GIF image and MP4 of the SVG inputted, starting with the background and one triangle for the first frame, then adding one triangle per frame

#### Dependencies
- bash
- ffmpeg
- php7.2-cli

#### Usage
`./animate.php [SVG]`

### chess, cube, cylinder, teapot, triangle, triangle2
V3D files

### *.stl
ASCII STL files

### file.svg
The output file that I was using

### README.md
This readme file

### stl2v3d.sh
BASH script to convert ASCII STL files to V3D files

#### Dependencies
- bash

#### Usage
`./stl2v3d.sh [ASCII STL] > [V3D]`

### vector3d.php
Vector3D

#### Dependencies
- php7.2-cli

#### Usage
Usage:   `./vector3d.php [options] > [output.svg]`<br>
Example: `./vector3d.php -i cube -z 1 > file.svg`

| Option | Discription |
| --- | --- |
| `-b` | background colour; default: `#FFF` |
| `-i` | v3d compliant file for input |
| `-h` | height of output svg; default: `480` |
| `-b` | background colour; default: `#FFF` |
| `-i` | v3d compliant file for input |
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
