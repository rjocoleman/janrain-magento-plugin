require 'watir/ie'

def is_element_subclass? klass
  while klass = klass.superclass
    return true if klass == Watir::Element
  end
end

ObjectSpace.each_object(Class){|c| puts c if is_element_subclass?(c)}