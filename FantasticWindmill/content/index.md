# A Test Sequence Generatior with Many Tricks

SealTest is a test sequence generation library: given an input *specification* describing the expected behaviour of a system, it produces a set of test *sequences* which, taken together, cover all parts of the specification.

## Features

- Easy generation of specification-based test sequences using a variety of built-in algorithms and coverage metrics
- Generic platform allowing a user to define their own types of events, triaging functions, specification languages, coverage metrics and trace generation algorithms. This makes it a useful platform for developing and comparing future works on test sequence generation in a uniform environment.
- Possibility to define *test hooks* so that the generated test sequences can translate into actual operations executed on a system under test.

The code is available online under the GNU Lesser General Public License; hence it can be used as a library inside any project, including closed-source or commercial products.

If you want to know more about the features of SealTest:

- Read the short [tutorial](/manual/quick-tutorial.html)
- Consult the online [API documentation](doc/)

## About LabPal

LabPal was developed by [Sylvain Hallé](http://leduotang.ca/sylvain), and Raphaël Khoury, professors at [Université du Québec à Chicoutimi](http://www.uqac.ca), Canada. Pr. Hallé is also the head of [LIF](http://liflab.ca), a research lab where LabPal is extensively used for the processing of experimental results.

<!-- :wrap=soft:mode=markdown: -->