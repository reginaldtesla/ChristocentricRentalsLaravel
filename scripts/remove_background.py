"""Remove image background and save a high-quality transparent PNG cutout."""

from __future__ import annotations

import io
import sys
from pathlib import Path

from PIL import Image
from rembg import remove

TARGET_LONG_EDGE = 2048
MAX_UPSCALE = 2.0


def upscale_if_needed(image: Image.Image) -> Image.Image:
    long_edge = max(image.size)

    if long_edge >= TARGET_LONG_EDGE:
        return image

    scale = min(TARGET_LONG_EDGE / long_edge, MAX_UPSCALE)
    new_size = (max(1, int(image.width * scale)), max(1, int(image.height * scale)))

    return image.resize(new_size, Image.Resampling.LANCZOS)


def main() -> int:
    if len(sys.argv) < 3:
        print("Usage: remove_background.py <input> <output.png>", file=sys.stderr)
        return 1

    input_path = Path(sys.argv[1])
    output_path = Path(sys.argv[2])

    if not input_path.is_file():
        print(f"Input not found: {input_path}", file=sys.stderr)
        return 1

    output_path.parent.mkdir(parents=True, exist_ok=True)

    with input_path.open("rb") as handle:
        result = remove(handle.read())

    image = Image.open(io.BytesIO(result)).convert("RGBA")
    image = upscale_if_needed(image)
    image.save(output_path, format="PNG", optimize=True)

    return 0


if __name__ == "__main__":
    raise SystemExit(main())
