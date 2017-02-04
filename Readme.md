# Instructions

This is the source repository for the SealTest web site. The site uses the
[FantasticWindmill](https://sylvainhalle.github.io/FantasticWindmill) static
web site generator to generate the pages.

## How to build the site

Clone both this repository and the [sealtest](https://github.com/liflab/sealtest)
side by side in the same root folder, like this:

    /somefolder
      /sealtest
      /sealtest-site

In the `sealtest-site`, go to the `FantasticWindmill` folder. To generate the
HTML files from the sources, type

    $ make

This will put all the static web site in the `public_html` folder.

To put the site "online", you need to copy the contents of this folder to the
`docs` folder of the `sealtest` repository. Run:

    $ make github

This command will only work if the `sealtest` repo is properly located relative
to `sealtest-site`, as mentioned above.

## How to modify the site

The contents of the site are in the `content` folder. Markdown files are
automatically converted to HTML when building. The structre of this folder
is faithfully mirrored in `public_html`: if you create folders in `content`,
there will be the same folders in `public_html`, etc.

In addition to copying the HTML files to the `sealtest` repository, don't forget
to commit/push your modifications to the sources in the `sealtest-site` repo.

## Javadoc

This site does *not* contain the Javadoc generated from the SealTest sources.
To update the sources and push them online, go to the `sealtest` repository and
run

    $ ant javadoc

This will regenerate the Javadoc ant put it in the `docs/doc` folder. Doing
a commit/push will update the Javadoc online.