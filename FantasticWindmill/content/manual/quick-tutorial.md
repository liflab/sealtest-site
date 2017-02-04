[User Manual](index.html)

# A quick tutorial

SealTest allows a user to generate test sequences of a wide range of types, according to potentially unlimited coverage metrics, by defining very simple building blocks that interact with existing functions and algorithms.

<h3>Event Types</h3>

The basic classes in SealTest make no assumption on the type of event contained in a trace, or on the type of objects used as categories by the triaging function. To this end, the top-level definitions of triaging function and trace are all parameterized with generic types, generally called `T` for events and `U` for categories. This makes it possible for the user to define arbitrary objects as events (provided they inherit from the `Event` superclass), and similarly for triaging functions.

Currently, SealTest does provide one predefined type of event, called the `AtomicEvent`. An atomic event is represented by a single symbol, which can be any character string. Atomic events can be used in finite-state automata and in propositional Linear Temporal Logic.

<h3>Writing Specifications</h3>

<h4>Finite-State Machines</h4>

FSMs can be created programmatically, by manually adding states and transitions:

<pre><code>Automaton aut = new Automaton();
Vertex&lt;AtomicEvent&gt; v0 = new Vertex&lt;&gt;(0);
v0.add(new Edge&lt;&gt;(0, new AtomicEvent("a"), 1));
aut.add(v0);
</code>
</pre>

Alternatively, SealTest also provides a parser that can build an automaton directly from a text file in GraphViz (DOT) format:

<pre><code>Scanner s = new Scanner(new File("fsm.dot"));
Automaton aut = Automaton.parseDot(s);
</code>
</pre>

<h4>LTL Specifications</h4>

SealTest also provides ways of writing LTL formul&aelig;:

<pre><code>Operator&lt;AtomicEvent&gt; op = new Globally&lt;&gt;(
  new Implies&lt;&gt;(
    new EventLeaf(new AtomicEvent("a")),
    new Next&lt;&gt;(
      new Or&lt;&gt;(new AtomicEvent("b"),
        new AtomicEvent("c"))
)));
</code>
</pre>

Alternatively, SealTest also provides a parser that can build an LTL formula directly from a string:

<pre><code>String formula = "G (a -&gt; (X (b | c)))";
AtomicParserBuilder parser = 
  new AtomicParserBuilder(formula);
Operator&lt;AtomicEvent&gt; op = parser.build();
</code>
</pre>

<h3>Traces</h3>

SealTest provides `AtomicEvent`; in turn, a trace of atomic events is an `AtomicTrace`. A trace can be created programmatically, or parsed from a string; the following code snippet shows both methods. Since a trace is a list of events, its concents can be enumerated and accessed like any other Java list.

<pre><code>Trace&lt;AtomicEvent&gt; trace1, trace2;
trace1 = new AtomicTrace();
trace1.add(new AtomicEvent("a");
trace2 = AtomicTrace.readTrace("a,b,c");
for (AtomicEvent e : trace1) {
  System.out.println(e);
}
</code>
</pre>







<h2>Generating Traces</h2>

<h3>Triaging Functions</h3>

A triaging function is&hellip;

<h4>Automata-Based Functions</h4>

Given a FSM specification, SealTest already provides a number of built-in triaging functions. For example, to classify a trace according to their state shallow history of length 2 with respect to some FSM, one writes:

<pre><code>Automaton aut = ...
Trace t = ...
StateShallowHistory f = 
  new StateShallowHistory(aut, 2);
MathSet&lt;Integer&gt; category = f.getStartClass();
for (AtomicEvent e : trace1) {
  category = f.processTransition(e);
}
</code>
</pre>

At the exit of the loop, variable `category` contains the category in which `f` places the trace.

<h4>Hologram-Based Functions</h4>

The same applies to LTL-based specifications. The following code example evaluates an LTL formula on a trace, and then applies a hologram transformation on the resulting evaluation tree.

<pre><code>Operator&lt;AtomicEvent&gt; op = ...
Trace t = ...
for (AtomicEvent e : t)
  op.evaluate(ae);
FailFastDeletion&lt;AtomicEvent&gt; f = 
  new FailFastDeletion&lt;&gt;();
Operator&lt;&gt; new_op = f.transform(op);
</code>
</pre>

In addition, SealTest allows the hologram to be exported as a picture, by producing a text file in Graphviz (DOT) format:

<pre><code>GraphvizHologramRenderer&lt;AtomicEvent&gt; renderer 
  = new GraphvizHologramRenderer&lt;AtomicEvent&gt;();
new_op.acceptPrefix(renderer, true);
System.out.println(renderer.toDot());
</code>
</pre>

<h4>User-Defined Functions</h4>
One simply needs to create a new class that extends `TriagingFunction`; for example, here is a simple triaging function that categorizes each trace with respect to the number of events named *a* it contains:

<pre><code>public class MyFunction 
extends TriagingFunction&lt;AtomicEvent,Integer&gt; {
  // Number of a's
  int num_a = 0;
  
  public Set&lt;Integer&gt; getStartClass() {
    return new MathSet&lt;Integer&gt;(0);
  }
  public Set&lt;U&gt; read(AtomicEvent e) {
    if (e.getLabel().compareTo("a") == 0)
      num_a++;
    return new MathSet&lt;Integer&gt;(num_a);
  }
  public void reset() {
    num_a = 0;
  }
}
</code>
</pre>

<h3>Coverage Metrics</h3>

TODO

<h3>Trace Generation</h3>

<h4>Cayley Graph Method</h4>
A first method to generate traces is by exploiting the Cayley graph of a triaging function. Here, `T` is the generic type of the events inside a sequence, and `U` is the type of the categories returned by the function. The new class needs to implement `getStartCategory()`, which returns the equivalence class of the empty trace, and `processTransition()`, which returns the equivalence class of the current sequence to which a new event is to be appended. Computing the Cayley graph associated to a function, as well as computing its prefix closure, can also be easily done using predefined objects:

<pre><code>TriagingFunction&ltT,U&gt; f = ...
CayleyGraph&ltT,U&gt; g = f.getCayleyGraph();
PrefixClosure&ltT,U&gt; closure 
  = new PrefixClosure&lt;&gt;(graph);
CayleyGraph&ltT,U&gt; closure_graph =  closure.getCayleyGraph();
</code>
</pre>

Note that the function can define its Cayley graph directly by overriding the `getCayleyGraph()` method; otherwise it defaults to calling  a generic graph exploration algorithm. Finally, generating a set of test sequences from a graph is also simple; for example, the following syntax shows how to use the hypergraph/Steiner tree algorithm to generate a set of sequences from an existing Cayley graph:
%
<pre><code>TraceGenerator<T> gen 
  = new HypergraphTraceGenerator&lt;&gt;(g);
Set<Trace<T>> traces = gen.generateTraces();
</code>
</pre>

<h4>Greedy Random Algorithm</h4>

SealTest also provides an alternate method of generating traces, using a random algorithm. This algorithm requires a coverage metric, an alphabet of possible events and a random number generator:

<pre><code>Automaton aut = ...
CoverageMetric<T,Float> metric = ...
Random rand = new Random();
GreedyAutomatonGenerator<T> gen = 
  new GreedyAutomatonGenerator&lt;&gt;(aut, rand, metric);
Set<Trace<T>> traces = gen.generateTraces();
</code>
</pre>

<h3>Test Driver and Test Hooks</h3>

A test hook is an object that receives events and is responsible for executing them on some system under test. Suppose for example that we want to test a `Microwave` object that has methods like `start`, `stop`, `open`, `setFood`, etc. We can create a simple `TestHook` object that receives atomic events, and depending on their name, makes a specific method call on a `Microwave` object it is given. The resulting hook could look like this:

<pre><code>class MicrowaveHook
  implements TestHook<AtomicEvent,Object> {
  
  Microwave oven;
  
  public MicrowaveHook(Microwave o) {
    oven = o;
  }
  public Object execute(AtomicEvent event) {
    String event_name = event.getLabel();
    if (event_name.compareTo("start") == 0)
      oven.start();
    if (event_name.compareTo("stop") == 0)
      oven.stop();
    ...
    return null;
  }
}
</code>
</pre>

Obviously, a test hook can be programmed to do other tasks, such as printing the event, logging it into a database, sending an HTTP request to some online system, etc. A test hook is used in conjunction with a <em>test driver</em>. The driver is given a set of traces, and executes each event they contain by calling the test hook. This set of traces can be built by hand, or, obviously, be constructed by a trace generator as described earlier.

<pre><code>TestSequenceGenerator gen = ...
TestSuite&lt;AtomicEvent&gt; suite = gen.generateTraces();
UnidirectionalTestDriver<AtomicEvent,Object> driver 
  = new UnidirectionalTestDriver&lt;&gt;();
driver.setTestSuite(suite);
MicrowaveHook hook = new MicrowaveHook(new Microwave());
driver.setHook(hook);
driver.run();
</code>
</pre>

Since a driver implements Java's `Runnable` interface, its interaction with the SUT can be placed inside a separate thread.



<!-- :wrap=soft:mode=markdown: -->